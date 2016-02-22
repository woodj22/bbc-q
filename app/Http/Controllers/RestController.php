<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;


abstract class RestController extends Controller
{
    protected $findAllWith = null;
    protected $postFields = null;
    protected $putFields = null;
    protected $allowedFilters = null;
    protected $allowedSearchFilters = null;

    protected $currentSearchTerm = null;
    public function index()


    {


        // Request Query String
        $model = new $this->modelType;

        $queryPerPage = Input::get('_perPage');
        $querySortDir = Input::get('_sortDir');
        $querySortField = Input::get('_sortField');
        $queryPage = Input::get('_page');
        $queryFilters = json_decode(Input::get('_filter'));
        $queryKeywords = json_decode(Input::get('_keyword'));
        $currentSearchQuery = Input::get('_search');

        // Initiate Filter Vars
        $perPage = $queryPerPage ? intval($queryPerPage) : 30;
        $page = $queryPage ? intval($queryPage) : 1;
        $skip = ($page - 1) * $perPage;

        if (isset($querySortDir) && isset($querySortField)) {
            $model = $model->orderBy($querySortField, $querySortDir); // Add sorting to our Query Builder
        }

        if ($queryFilters) {
            foreach ($queryFilters as $key => $value) {
                if (in_array($key, $this->allowedFilters)) {
                    $model = $model->where($key, $value);
                }
            }
        }

        if ($currentSearchQuery) {
            $terms = explode(" ", $currentSearchQuery);
            foreach ($terms as $term){
                $this->currentSearchTerm = $term;
                $model = $model->where(function ($model) {
                    if (isset($this->allowedSearchFilters)){
                        $search = $this->allowedSearchFilters;
                    }
                    else{
                        $search = $this->allowedFilters;
                    }
                    foreach ($search as $key) {
                        $model->orWhere($key, 'LIKE', '%'.$this->currentSearchTerm.'%');
                    }
                });
            }

        }

        if ($queryKeywords && is_array($queryKeywords)){
            foreach ($queryKeywords as $keyword){
                $model = $model->whereHas('keywords', function($model) use ($keyword)
                {
                    $model->where('name', $keyword);
                });
            }
        }

        $count = $model->count(); // Get Query Count

        $model = $model->skip($skip)->take($perPage);
        $contentRange = ($skip + $perPage) > $count ? $count : ($skip + $perPage);

        if (is_array($this->findAllWith)) {
            foreach ($this->findAllWith as $withItem) {
                $model = $model->with($withItem);
            }
        }

        $model = $model->get();

        return response()->json($model)
            ->header('X-Per-Page', $perPage)
            ->header('X-Current-Page', $page)
            ->header('X-Total-Pages', ceil($count / $perPage))
            ->header('X-Total-Count', $count)
            ->header('Content-Range', 'entities '.($skip + 1).'-'.$contentRange.'/'.$count)
            ->header('Access-Control-Expose-Headers', 'X-Per-Page, X-Current-Page, X-Total-Pages, X-Total-Count, Content-Range');
    }

    public function show($id)
    {
        $instance = new $this->modelType;
        if ($this->findAllWith) {
            $model = $instance::with($this->findAllWith)->findOrFail($id);
        } else {
            $model = $instance->findOrFail($id);
        }

        return response()->json($model);
    }

    public function destroy($id)
    {
        $instance = new $this->modelType;

        $model = $instance::findOrFail($id);
        $model->delete();

        return response()->json(['success' => true]);
    }

    public function rootStore($request)
    {

        $body = $request->json()->all(); // JSON Request Body
        $body = (object)$body;

        $model = new $this->modelType;
        $instance = new $this->modelType;

        foreach ($this->postFields as $field) {
            $model->$field = @$body->$field;
        }

        if ($model->save()) {

            if ($this->findAllWith) {

                $model = $instance::with($this->findAllWith)->findOrFail($model->id);
            } else {
                $model = $instance->findOrFail($model->id);
            }

            return response()->json($model);
        }

        App::abort(500, 'Unable to save record');
    }

    public function rootUpdate($request, $id)
    {

        $instance = new $this->modelType;

        $body = $request->json()->all(); // JSON Request Body

        $body = (object)$body;
        if ($this->findAllWith) {
            $model = $instance::with($this->findAllWith)->findOrFail($id);
        } else {
            $model = $instance->findOrFail($id);
        }

        foreach ($this->putFields as $field) {
            if (isset($body->$field)) {
                $model->$field = @$body->$field;
            }
        }

        if ($model->save()) {
            return response()->json($model);
        }

        App::abort(500, 'Unable to save record');
    }

}
