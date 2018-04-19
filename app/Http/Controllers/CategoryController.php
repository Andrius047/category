<?php

namespace App\Http\Controllers;

use App\category;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cat_list = \DB::table('categories')->select('id','category','parent')->get();
        $tree = $this->buildTree($cat_list);

        var_dump($tree);
        die;


        $categories = Category::all();
        $categoriesf = $this->buildArray($categories->toArray());

        return view('category.index', ['cat' => $categoriesf, 'categories' => $categories, 'tree' => $tree]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cat_list = \DB::table('categories')->select('id','category')->get();

        return view('category.create')->with('cat', $cat_list);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $cat = new category;

        $cat->category = $request->input('category');
        $cat->parent = $request->input('parent');

        $cat->save();

        return redirect()->route('category.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    function buildTree($items) {

        $childs = array();

        foreach($items as $item)
            $childs[$item->parent][] = $item;

        foreach($items as $item) if (isset($childs[$item->category]))
            $item->childs = $childs[$item->category];

        return $childs;
    }

    function buildArray(array $objects, array &$result=array(), $parent=0, $depth=0)
    {
        foreach ($objects as $key => $object) {
            if ($object['parent'] == $parent) {
                $object['depth'] = $depth;
                array_push($result, $object);
                unset($objects[$key]);
                CategoryController::buildArray($objects, $result, $object['id'], $depth + 1);
            }
        }
        return $result;
    }

}
