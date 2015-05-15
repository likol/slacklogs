<?php

class User extends Moloquent
{
    protected $connection = 'mongodb';

    protected $collection = 'users';

    protected $fillable = ['sid', 'name', 'deleted', 'color' ,'profile'];
}
