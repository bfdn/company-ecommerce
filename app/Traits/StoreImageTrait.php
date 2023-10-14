<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait StoreImageTrait
{
    /**
     * Does very basic image validity checking and stores it. Redirects back if somethings wrong.
     * @Notice: This is not an alternative to the model validation for this field.
     *
     * @param Request $request
     * @return $this|false|string
     */
    public function verifyAndStoreImage(Request $request, $fieldname = 'image', $directory = 'unknown')
    {
        if ($request->hasFile($fieldname)) {
            $images = $request->file($fieldname);

            if (!is_array($images)) {
                if (!$images->isValid()) return redirect()->back()->withInput();
                //flash('Invalid Image!')->error()->important();
                return "storage/" . $request->file($fieldname)->store('image/' . $directory, 'public');
            } else {
                $file_data = [];
                foreach ($images as $image) {
                    if ($image->isValid()) {
                        $file_data[] = "storage/" . $image->store('image/' . $directory, 'public');
                    }
                }
                // dd($file_data);
                return json_encode($file_data, JSON_UNESCAPED_UNICODE);
            }

            // return $request->file($fieldname)->storeAs('image/' . $directory, 'dosyaadi.jpg','public'); // storeAs dosya adı değiştirildiyse kullanılır.
        }
        return null;
    }
}
