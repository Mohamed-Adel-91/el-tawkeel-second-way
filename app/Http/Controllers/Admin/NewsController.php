<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\FileServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\NewsRequest;
use App\Models\News;
use App\Models\Writer;
use App\Models\CarModel;

class NewsController extends Controller
{
    protected FileServiceInterface $fileService;

    public function __construct(FileServiceInterface $fileService)
    {
        $this->fileService = $fileService;
    }

    public function index()
    {
        $data = News::with(['writer', 'carModel'])->orderBy('added_date', 'desc')->paginate(25);
        return view('admin.news.index')->with([
            'pageName' => 'قائمة الأخبار',
            'data' => $data,
            'filters' => [],
        ]);
    }

    public function create()
    {
        $writers = Writer::orderBy('id', 'desc')->get();
        $carModels = CarModel::with('brand')->orderBy('id', 'desc')->get();
        return view('admin.news.form')->with([
            'pageName' => 'إنشاء خبر',
            'writers' => $writers,
            'carModels' => $carModels,
        ]);
    }

    public function store(NewsRequest $request)
    {
        $data = $request->validated();
        $news = News::create($data);
        $folder = News::UPLOAD_FOLDER;
        $this->fileService->storeFiles($news, $request, ['home_img', 'thumb_img'], $folder);
        return redirect()->route('admin.news.index')->with('success', 'تم إنشاء الخبر بنجاح.');
    }

    public function edit($id)
    {
        $data = News::findOrFail($id);
        $writers = Writer::orderBy('id', 'desc')->get();
        $carModels = CarModel::with('brand')->orderBy('id', 'desc')->get();
        return view('admin.news.form')->with([
            'pageName' => 'تعديل خبر',
            'data' => $data,
            'writers' => $writers,
            'carModels' => $carModels,
        ]);
    }

    public function update(NewsRequest $request, $id)
    {
        $news = News::findOrFail($id);
        $data = $request->validated();
        $data['is_old'] = $data['is_old'] ?? $news->is_old;
        $news->update($data);
        $folder = News::UPLOAD_FOLDER;
        $this->fileService->updateFiles($news, $request, ['home_img', 'thumb_img'], $folder);
        return redirect()->route('admin.news.index', $request->query())->with('success', 'تم تحديث الخبر بنجاح.');
    }

    public function destroy($id)
    {
        $news = News::findOrFail($id);
        $folder = News::UPLOAD_FOLDER;
        $this->fileService->deleteFile($news->home_img,  $folder);
        $this->fileService->deleteFile($news->thumb_img, $folder);
        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'تم حذف الخبر بنجاح.');
    }
}
