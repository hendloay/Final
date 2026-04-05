<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    // عرض قائمة المهام
    public function index()
    {
        $tasks = Task::with(['category', 'user'])->get();
        return view('cms.tasks.index', compact('tasks'));
    }

    // عرض صفحة إنشاء مهمة جديدة
    public function create()
    {
        $categories = Category::all();
        $users = User::all();
        return view('cms.tasks.create', compact('categories', 'users'));
    }

    // تخزين مهمة جديدة
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:pending,completed',
        ]);

        if ($validator->passes()) {
            Task::create($request->all());
            return response()->json(['message' => 'تم إضافة المهمة بنجاح!'], 201);
        }
        return response()->json(['message' => $validator->getMessageBag()->first()], 400);
    }

    // --- هاد الجزء اللي كان ناقص ومسبب الخطأ في الصورة الثانية ---
    public function edit(Task $task)
    {
        $categories = Category::all();
        $users = User::all();
        return view('cms.tasks.edit', compact('task', 'categories', 'users'));
    }

    // تحديث المهمة
    public function update(Request $request, Task $task)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'category_id' => 'required',
            'user_id' => 'required',
            'status' => 'required',
        ]);

        if ($validator->passes()) {
            $task->update($request->all());
            return response()->json(['message' => 'تم التعديل بنجاح!'], 200);
        }
        return response()->json(['message' => $validator->getMessageBag()->first()], 400);
    }

    // حذف ناعم (إرسال للأرشيف)
    public function destroy(Task $task)
    {
        $isDeleted = $task->delete();
        if ($isDeleted) {
            return response()->json(['icon' => 'success', 'title' => 'نجح الحذف', 'text' => 'تم نقل المهمة للأرشيف'], 200);
        }
        return response()->json(['icon' => 'error', 'title' => 'فشل الحذف'], 400);
    }

    // عرض الأرشيف
    public function trashed()
    {
        $tasks = Task::onlyTrashed()->with(['category', 'user'])->get();
        return view('cms.tasks.trashed', compact('tasks'));
    }

    // استرجاع من الأرشيف
    public function restore($id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        $task->restore();
        return response()->json(['icon' => 'success', 'title' => 'تم الاسترجاع', 'text' => 'المهمة عادت للقائمة الرئيسية'], 200);
    }

    // حذف نهائي
    public function forceDelete($id)
    {
        $task = Task::withTrashed()->findOrFail($id);
        $task->forceDelete();
        return response()->json(['icon' => 'success', 'title' => 'حذف نهائي', 'text' => 'تم حذف المهمة تماماً من النظام'], 200);
    }
}