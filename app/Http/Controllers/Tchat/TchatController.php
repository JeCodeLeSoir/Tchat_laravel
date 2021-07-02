<?php

//JeCodeLeSoir

namespace App\Http\Controllers\Tchat;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Models\TchatModel;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Illuminate\Support\Facades\Cache;

class TchatController extends Controller
{

    /**
     * Add message in base
     *
     * @param  Request  $request
     * @return Response
     */
    public function SendMessage(Request $request)
    {
        $v = Validator::make($request->all(), [
            'name' => 'required|min:4|max:255',
            'message' => 'required',
        ]);

        if ($v->fails())
        {
            return \json_encode(['Valide' => false, 'Errors' => $v->errors()]);
        }
        else{
            $data = $request->input();

            //File -> app/http/controller/Models/TchatModel.php

            $Tchat = new TchatModel;
            $Tchat->name = \htmlentities($data['name']);
            $Tchat->message = \htmlentities($data['message']);
			$Tchat->save();

            $messageCache = Cache::get('Message');
            
            if( $messageCache == null){
                $messageCache = [];
            }

            $messageCache [] = [
                "id" => $Tchat->id,
                "name" => \htmlentities($data['name']), 
                "message" => \htmlentities($data['message']),
                "created_at" => $Tchat->created_at->toDateTimeString()
            ];

            if (!Cache::has('Message')) {
                Cache::add('Message', $messageCache, 600);
            }
            else
                Cache::put('Message', $messageCache, 600);

            return \json_encode(['Valide' => true]);
        }
    }

    //Folder -> resources/views/pages
    public function ShowAllMessage(Request $request){
        return view('pages/tchat', [
            'messages' => 
            TchatModel::orderBy('updated_at', 'desc')
            ->paginate(8)
            ->reverse()
        ]);
    }

    public function ShowAllMessageByJson(Request $request){
        return \json_encode([
            'messages' => 
            TchatModel::orderBy('updated_at', 'desc')
            ->paginate(8)
            ->reverse()
        ]);
    }

    public function ServerSendEvent(Request $request){

        $response = new StreamedResponse(function() use ($request) {

            $last = null;

            while(true) {

                $messageCache = Cache::get('Message');

                if ($messageCache != []) {
                    echo 'data: ' . json_encode($messageCache) . "\n\n";
                    ob_flush();
                    flush();
                }
                     
                usleep(100000);
                
                if ($last != $messageCache) {
                    $last = [];
                    if (Cache::has('Message')) {
                        Cache::put('Message', [], 600);
                    }
                }

                usleep(100000);
            }
        });

        $response->headers->set('Content-Type', 'text/event-stream');
        $response->headers->set('X-Accel-Buffering', 'no');
        $response->headers->set('Cach-Control', 'no-cache');

        return $response;
    }
}

?>