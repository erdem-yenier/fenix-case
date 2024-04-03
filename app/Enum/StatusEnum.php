<?php
namespace App\Enum;


enum StatusEnum: string {

    case SUCCESS = 'Success';
    case ERROR = 'Error';
    case INFO = 'Info';
    case WARNING = 'Warning';

}