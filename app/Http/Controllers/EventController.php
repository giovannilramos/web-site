<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\User;
use App\Models\Categorias;


class EventController extends Controller
{
    //Pagina de emissao de dados
    public function index() {
        /*O valor que é chamado na outra página é o valor nas aspas
        e o valor com cifrão é o valor que vai ser atribuido*/
        $categorias = Categorias::all();
        $user = auth()->user();

        $events = $user->events;

        $eventsAsParticipant = $user->eventsAsParticipant;

        return view('events.eventos', [
        'events' => $events, 
        'eventsasparticipant' => $eventsAsParticipant, 
        'categorias'=>$categorias
        ]);
    }

    //Form pra realizer a criaçao do evento
    public function create() {
        $categorias = Categorias::all();
        return view('events.create', [
            'categorias'=>$categorias
        ]);
    }

    //Insert
    public function store (Request $request) {
        //$request->title é como o $_POST['title'] 

        $events = new Event;

        $events->title = $request->title;
        $events->date = $request->date;
        $events->city = $request->city;
        $events->private = $request->private;
        $events->description = $request->description;
        $events->items = $request->items;

        if($request->hasFile('image') && $request->file('image')->isValid()) {
            //Recebe a imagem passada no form    
            $requestImage = $request->image;
            //pega a extensao da imagem (jpg, png...)
            $extension = $requestImage->extension();
            //Deixa o nome do arquivo unico e dps do now é o jeito que o arquivo vai ficar salvo
            //concatenando com a extensao dele
            $imageName = md5($requestImage->getClientOriginalName().strtotime("now").".".$extension);
            //adicionar imagem na pasta
            $requestImage->move(public_path('img/events'), $imageName);
            //passa o valor pro post
            $events->image = $imageName;
        }

        $user = auth()->user();
        $events->user_id = $user->id;

        $events->save();
        
        //Flash message, messagem que aparece pro usuário ao obter sucesso no processo, precisa ser 
        //chamado no blade
        return redirect('/')->with('msg','Evento criado com sucesso!');
    }

    //Select por id
    public function show($id) {
        $events = Event::findOrFail($id);

        $user = auth()->user();
        $hasUserJoined = false;

        if ($user) {
            $userEvents = $user->eventsAsParticipant->toArray();

            foreach($userEvents as $userEvent) {
                if ($userEvent['id'] == $id) {
                    $hasUserJoined = true;
                }
            }
        }

        $eventOwner = User::where('id', $events->user_id)->first()->toArray();
        $categorias = Categorias::all();

        return view('events.show', [
            'events'=>$events, 
            'eventOwner'=>$eventOwner, 
            'categorias'=>$categorias,
            'hasUserJoined'=>$hasUserJoined
        ]);
    }
    //Delete
    public function destroy($id) {
        Event::findOrFail($id)->delete();
        return redirect('/')->with('msg','Evento excluído com sucesso!');
    }

    //Metodo para pegar o id do objeto a ser modificado
    public function edit($id) {
        $events = Event::findOrFail($id);
        $categorias = Categorias::all();

        //verificação para impedir que um usuário possa editar um evento criado por outra pessoa
        $user = auth()->user();

        if ($user->id != $events->id) {
            return redirect('/');
        }

        return view('events.edit', ['events'=>$events, 'categorias'=>$categorias]);
    }

    //Update
    public function update(Request $request) {
        Event::findOrFail($request->id)->update($request->all());
        return redirect('/')->with('msg', 'Evento editado com sucesso!');
    }

    //many to many, para fazer com que a pessoa participe do evento ao clicar no botao
    public function joinEvent($id) {
        $user = auth()->user();

        $user->eventsAsParticipant()->attach($id);

        $event = Event::findOrFail($id);

        return redirect('/')->with('msg','Participação confirmada no evento: '.$event->title);

    }

    //usuario sai do evento
    public function leaveEvent($id) {
        $user = auth()->user();

        $user->eventsAsParticipant()->detach($id);
        $event = Event::findOrFail($id);

        return redirect('/')->with('msg','Saiu do evento com sucesso!');
    }

}
