<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use Image;


class FormController extends Controller
{
    //
     public function post_form_data(Request $request)
    {
    	$resize = FALSE;

		$this->validate($request, [
            'name' => 'required',
            'email' => 'required',
          
        ]);
  
		$data = $request->all();
    	$newProfile = new Profile;


        $image = $request->file('profile_photo');
        $input['imagename'] = time().'.'.$image->extension();
     
        $filePath = public_path('/profilepics');

        $newProfile->name = strip_tags($data['name']);
    	$newProfile->email = strip_tags($data['email']);
    	$newProfile->profilephoto_orig = $filePath."/". $input['imagename'] ;
    	
        $img = Image::make($image->path());

        $height = Image::make($image->path())->height();
        $width = Image::make($image->path())->width();
        if ($height > 500) {
        	$height = 500;
			$resize = TRUE;
        }
        if ($width > 500) {
        	$width = 500;
			$resize = TRUE;
        }
        //dd($height . ',' . $width);
        // Save Original Image
        $img->save($filePath.'/'.$input['imagename']);
        
        // Resize image if more than 500x500
        if ($resize) {
        	$img->resize($width, $height, function ($const) {
            	$const->upsize();
        	})->save($filePath.'/resized_'.$input['imagename']);
   			$newProfile->profilephoto_500px = $filePath."/resized_". $input['imagename'];
   		} else
   		{
   			$newProfile->profilephoto_500px = "";
   		}

   		// Save DATA to Profile
    	
    	$newProfile->save();

        return response()->json(['success'=>'Form is successfully submitted!']);

    }
}
