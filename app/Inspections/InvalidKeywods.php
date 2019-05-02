<?php 

namespace App\Inspections;

use Exception;

class InvalidKeywords 
{
    protected $keywords = [
        'test invalid'
    ];

    public function detect($body)
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