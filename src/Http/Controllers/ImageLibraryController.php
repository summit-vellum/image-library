<?php

namespace Quill\ImageLibrary\Http\Controllers;

use Illuminate\Http\Request;
use Quill\ImageLibrary\Http\Controllers\BaseController;
use Vellum\Contracts\Resource;
use Quill\ImageLibrary\Models\ImageLibrary;
use Vellum\Module\Module;
use Illuminate\Support\Arr;
use Vellum\Helpers\AwsHelper as AWS;

class ImageLibraryController extends BaseController
{
    protected $resource;
    public $module;

    public function __construct(Resource $resource, Module $module)
    {
    	parent::__construct();
        $this->resource = $resource;
        $this->module = $module;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ImageLibrary $imageLibrary, Request $request)
    {
    	$limit = $request->input('limit', ($this->site['pagination_limit']?$this->site['pagination_limit']:30));
        $data['limit'] = $limit;

        $form = $request->input('form');
		$target = $request->input('target');
        $keyword = $request->input('keyword', false);

        if ($keyword) {
            $imageLibrary = $imageLibrary->whereNameLike($keyword);
        }

    	$data = [];

    	$data['form'] = $form;
		$data['target'] = $target;
    	$data['images'] = $imageLibrary->orderById()->paginate($limit);
    	$data['img_source'] = $this->site['image_domain'];
    	$data['code_name'] = $this->site['code_name'];

    	if ($request->ajax()) {
            return response()->json($data, 200);
        }

    	return template('index', $data, $this->module->getName());
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, AWS $aws)
    {
    	$exclude_fields = ['_token', '_method', 'submit'];
        $payloads = $request->except($exclude_fields);

        $this->validate($request, [
            'file' => 'required|image|mimes:png,jpg,jpeg,bmp,gif|max:500'
        ]);

        $image = $request->file('file');

        $public_path = public_path('images');
        $image_library = $this->site['image_library'];
        $date = date('Y/m/d');

        // image details
        $name = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $image->getClientOriginalExtension();
        $image_name = seoUrl($name, '-').'-'.time().'.'.strtolower($extension);

        // upload in image directory
        $path = $public_path.$image_library.$date;

        $image_path = $this->site['image_path'].$date.'/'. $image_name;

        // insert record to image library
        $imageLibrary = new ImageLibrary([
            'path' => $image_path,
            'contributor' => $payloads['contributor'],
            'contributor_fee' => $payloads['contributor_fee'],
            'tags' => $payloads['tags'],
            'illustrator' => $payloads['illustrator']
        ]);

        $imageLibrary->save();

        $aws->uploadFileToS3($image_path, $image->getPathName(), $extension);

        //$image->move($path, $image_name);

        // return callback
        $return = [
            'status'     => '1',
            'code'       => '200',
            'message'    => 'success',
            'image_id'   => $imageLibrary->id,
            'image_path' => $imageLibrary->path
        ];

        return response()->json($return);
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
    public function update(Request $request, ImageLibrary $imageLibrary, $id)
    {
        $exclude_fields = ['_token', '_method', 'submit'];
        $payloads = $request->except($exclude_fields);

        $target = $payloads['target'];
        $details = Arr::except($payloads, ['id', 'caption', 'target']);

        // update image library
        $imageLibrary = $imageLibrary->find($id);

        foreach ($details as $key => $value) {
            $imageLibrary->$key = $value;
        }

        $imageLibrary->save();

        return redirect('image-library/feed?target='.$target);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(ImageLibrary $imageLibrary, $id)
    {
        $imageLibrary = $imageLibrary->find($id);
        if($imageLibrary) $imageLibrary->delete();

        return response()->json(['success' => true], 200);
    }
}
