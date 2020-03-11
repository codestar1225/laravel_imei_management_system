<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetailImeisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detail_imeis', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('imei');
            $table->string('brand');
            $table->string('model');
            $table->string('purchase_date');
            $table->string('start_coverage');
            $table->string('purchase_invoice');
            $table->string('customer_name');
            $table->bigInteger('contact_number');
            $table->string('email_address');
            $table->date('incident_date');
            $table->time('incident_time');
            $table->string('incident_location');
            $table->text('incident_detail');
            $table->string('repair_type');
            $table->string('repair_date');
            $table->string('repair_amount');
            $table->string('charges');
            $table->string('state');
            $table->string('service_centre_location');
            $table->string('pre_repair_photo');
            $table->string('post_repair_photo');
            $table->string('service_repair_report');
            $table->integer('claimed');
            $table->bigInteger('admin_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_imeis');
    }
}
