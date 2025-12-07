<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\FileServiceInterface;
use App\Http\Controllers\Controller;
use App\Http\Requests\VideoRequest;
use App\Models\CarModel;
use App\Models\Video;

class VideoController extends Controller
{
    protected FileServiceInterface $fileService;

    public function __construct(FileServiceInterface $fileService)
    {
        $this->fileService = $fileService;
    }
    public function index()
    {
        $data = Video::with('carModel')->orderBy('ord','desc')->paginate(25);
        return view('admin.videos.index')->with([
            'pageName' => 'قائمة الفيديوهات',
            'data' => $data,
            'filters' => [],
        ]);
    }

    public function create()
    {
        return view('admin.videos.form')->with([
            'pageName' => 'إضافة فيديو',
            'models' => CarModel::with('brand')->get(),
        ]);
    }

    public function store(VideoRequest $request)
    {
        $validated = $request->validated();
        $videos = Video::create($validated);
        $folder = Video::UPLOAD_FOLDER;
        $this->fileService->storeFiles($videos, $request, ['thumb_image'], $folder);
        return redirect()->route('admin.videos.index')->with('success', 'تم إنشاء الفيديو بنجاح.');
    }

    public function edit($id)
    {
        $data = Video::findOrFail($id);
        return view('admin.videos.form')->with([
            'pageName' => 'تعديل الفيديو',
            'data' => $data,
            'models' => CarModel::with('brand')->get(),
        ]);
    }

    public function update(VideoRequest $request, $id)
    {
        $video = Video::findOrFail($id);
        $validated = $request->validated();
        $video->update($validated);
        $folder = Video::UPLOAD_FOLDER;
        $this->fileService->updateFiles($video, $request, ['thumb_image'], $folder);
        return redirect()->route('admin.videos.index', $request->query())->with('success', 'تم تحديث الفيديو بنجاح.');
    }

    public function destroy($id)
    {
        $video = Video::findOrFail($id);
        $folder = Video::UPLOAD_FOLDER;
        $this->fileService->deleteFile($video->thumb_image, $folder);
        $video->delete();
        return redirect()->route('admin.videos.index')->with('success', 'تم حذف الفيديو بنجاح.');
    }
}
