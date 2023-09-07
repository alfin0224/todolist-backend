<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint as MongoBlueprint;

class CreateTasksCollection extends Migration
{
    public function up()
    {
        Schema::connection('mongodb')->create('tasks', function (MongoBlueprint $collection) {
            $collection->id();
            $collection->string('title');
            $collection->text('description');
            $collection->dateTime('due_date');
            $collection->boolean('completed')->default(false);
            $collection->string('email');
            $collection->boolean('reminder_status')->default(false);
            $collection->dateTime('reminder_date')->nullable();
            $collection->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('mongodb')->dropIfExists('tasks');
    }
}

