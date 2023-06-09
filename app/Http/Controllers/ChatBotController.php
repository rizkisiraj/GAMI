<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class ChatBotController extends Controller
{
    public function getGPTResponse(Request $request) {
        $items = $this->getItemsData();
        
            $payload = [
                'model' => 'text-davinci-003',
                'prompt' => $items . "Berdasarkan data ini, jawablah pertanyaan yang diajukan. Jika anda merekomendasikan produk maka anda bisa menambahkan link item dengan format <a href='http://127.0.0.1:8000/barang/{id_item}'>{name}</a>. Pertanyaannya adalah ini : " . $request->chatInput . '.',
                'temperature' => 0.5,
                'max_tokens' => 300,
                'top_p' => 1,
                'frequency_penalty' => 0,
                'presence_penalty' => 0,
            ];
    
            $response = Http::withHeaders([
                'Authorization' => 'Bearer'.' '.env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ])->post('https://api.openai.com/v1/completions', $payload);
    
            return $response;
    }

    public function getItemsData() {
        $result = Item::join('categories','categories.id','=','items.category_id')->join('colors','colors.id','=','items.color_id')->select('items.id','items.name','items.sex','items.size','categories.name as category','colors.name as color','items.region_of_origin')->where('is_sold','=',0)->where('is_deleted','=',0)->get();

        $header = 'id,name,sex,size,category,color, region_of_origin';

        // Create the data rows
        $rows = $result->map(function ($result) {
            return implode(',', [
                $result->id,
                $result->name,
                $result->sex,
                $result->size,
                $result->category,
                $result->color,
                $result->region_of_origin,
            ]);
        })->join("\n");

        $output = $header . "\n" . $rows;
        return $output;
    }
}
