<?php
namespace App\Repositories\Category;

use App\Models\Category;
use App\Repositories\BaseRepository;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function getModel()
    {
        return Category::class;
    }

    public function getAll()
    {
        return Category::where('status', config('const.active'))->orderBy('id')->get();
    }

    public function delete($id)
    {
        $result = $this->find($id);
        if ($result) {
            $result->status = 'disable';
            $result->save();
            $childcategories = $result->childcategories;
            foreach ($childcategories as $key => $value) {
                $value->parent_id = null;
                $value->save();
            }

            return true;
        }

        return redirect()->route('admindashboard');
    }

    public function update($id, $attributes = [])
    {
        $result = $this->find($id);
        if ($result) {
            $result->update($attributes);

            return true;
        }

        return redirect()->route('admindashboard');
    }
}
