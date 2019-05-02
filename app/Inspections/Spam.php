<?php 

namespace App\Inspections;

use Exception;

class Spam 
{
    protected $inspections = [
        InvalidKeywords::class,
        KeyHeldDown::class
    ];

    public function detect($body)
    {
        // foreach ($this->inspections as $inspection) {
        //     // dd($inspection);
        //     app($inspection)->detect($body);
            
        // }

        $this->InvalidKeywords($body);
        $this->keyHeldDown($body);

        return false;
    }

    public function InvalidKeywords($body)
    {
        if(preg_match('/(.)\\1{4,}/',$body)){
            throw new Exception('your reply has contains spam'); 
        };
    }

    public function keyHeldDown($body)
    {
        foreach ($this->keywords as $keyword) 
        {
            if(stripos($body,$keyword) !== false) 
            {
                throw new Exception('your reply has contains spam'); 
            }
        }
    }

}