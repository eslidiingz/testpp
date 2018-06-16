<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImageRequest;
use App\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{

	public function index() {
	  return Image::all();
	}


	public function store(ImageRequest $request) {

  	foreach ( $request->images as $file ) {
  		$filename = $file->store(null);

  		$image = new Image;
			$image->filename  = $filename;
			$image->type      = Storage::mimeType($filename);
			$image->bytes     = Storage::size($filename);
			$image->magabytes = number_format(($image->bytes / 1024 / 1024), 2);
  		$image->save();
  	}

    return response(['status' => 'uploaded success'], 200);
	}


	public function destroy(Image $image) {
		$filename = $image->filename;

		if ( $image->delete() ){
			Storage::delete($filename);
		}

	  return response(['status', 'delete success fully.']);
	}


	public function diskUsage() {
		$bytes = 0;

		$response['disk_overview']['no_of_files'] = Image::all()->count();
		$response['disk_overview']['total_size']['bytes'] = Image::sum('bytes');
		$response['disk_overview']['total_size']['magabytes'] = Image::sum('magabytes');

		$types = Image::selectRaw('`type`, count(`type`) as no_of_files, sum(`bytes`) as `bytes`, sum(`magabytes`) as `magabytes`')
			->groupBy('type')
			->get();

		$response['disk_composition'] = $types;

	  return response()->json($response);
	}

}
