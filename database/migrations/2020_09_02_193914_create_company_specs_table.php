<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanySpecsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_specs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedBigInteger('specialization_id');
            $table->foreign('specialization_id')->references('id')->on('specializations')->onDelete('cascade');
        });
    }
    /**
     *  $categories = $request->category_id;
        $tags = $request->tag_id;
     *  $blogCategories = [];
    $blogTags = [];
     *  foreach ($categories as $c) {
    array_push($blogCategories, ['category_id' => $c, 'blog_id' => $blog->id]);
    }
    Blogcategory::insert($blogCategories);
    // insert blog tags
    foreach ($tags as $t) {
    array_push($blogTags, ['tag_id' => $t, 'blog_id' => $blog->id]);
    }
    Blogtag::insert($blogTags);
     *
     *
     * DB::beginTransaction();
     * try{
     *      dodawanie do bazy
     *      DB::commit();
     * }catch(\Throwable $th) {
     * DB::rollback();  cofnięcie zmian jeśli w połowie dodawania wystąpił błąd
     * }
     *
    */
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_specs');
    }
}
