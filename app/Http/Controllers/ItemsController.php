<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class ItemsController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $keyword = request()->keyword;
        $items = [];
        if($keyword) {
            $client = new RakutenRws_Client();
            $client->setApplicationId(env('RAKUTEN_APPLICATION_ID'));
            
            $rws_response = $client->execute('IchibaItemSearch', [
                'keyword' => $keyword,
                'imageFlag' => 1,
                'hits' => 20,
            ]);
            
            // 扱いやすいように保存しない
            foreach ($rws_response->getData()['Items'] as $rws_item) {
                // code...
                $item = new Item();
                $item->code = $rws_item['Item']['itemCode'];
                $item->name = $rws_item['Item']['itemName'];
                $item->url = $rws_item['Item']['itemUrl'];
                $item->image_url = str_replace('?_ex=128x128', '', $rws_item['Item']['midiumImageUrls'][0]['imageUrl']);
                $items[] = $item;
            }
        }
        
        return view('items.create', [
            'keyword' => $keyword,
            'items' => $items,
        ]);
            
    }

}
