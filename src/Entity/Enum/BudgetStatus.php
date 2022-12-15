<?php

namespace App\Entity\Enum;

enum BudgetStatus: string
{
    case ToBeDone = 'toBeDone';
    case Draft = 'draft';
    case Completed = 'completed';
}