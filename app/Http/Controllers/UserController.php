<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;
use App\Models\Assign;
use Illuminate\Support\Facades\DB;
use DataTables;
use Laravel\Pail\ValueObjects\Origin\Console;


class UserController extends Controller
{
  public function show()
  {
    return view('admin.user');
  }
  public function getData(Request $request)
  {
    $data = User::where('usertype', '=', 'user')->get();
    return datatables()->of($data)
      ->addColumn('addcourse', function ($row) {
        return "<a href='" . route('admin/addcourseuser', ['emailluser' => $row->email]) . "' class='btn btn-primary' style='margin-top:10px'>Add Course</a>";
      })
      ->addColumn('addmark', function ($row) {
        return "<a href='" . route('admin/addmarkuser', ['emailluser' => $row->email]) . "' class='btn btn-primary' style='margin-top:10px'>Add Mark</a>";
      })
      ->rawColumns(['addmark', 'addcourse'])
      ->make(true);
  }
  public function addcourseuser($emailluser)
  {
    $course = Product::where('teacher_id', '=', value: Auth::id())->get();
    return view('admin.addcourseuser', compact(['course'], ['emailluser']));
  }

  public function assign(Request $request)
  {
   

    $validation = $request->validate([
      'Email' => 'required',
      'teacher_id' => 'required|integer', 
      'Course' => 'required|regex:/^([a-zA-Z]+)(\s[a-zA-Z]+)*$/',
    ]);
    
    $getCourse = Assign::where('Email', '=', $request->Email)
      ->where('Course', '=', $request->Course)
      ->where('teacher_id', '=', Auth::id())
      ->get();
    if ($getCourse->isNotEmpty()) {
      return response()->json([
        'success' => false,
        'message' => 'You have already added this course',
        'errors' => ['name' => ['You have already added this course for this student']]
      ], 422);
    }
    Assign::create($validation);
    return response()->json(['success' => 'Added Course succedsdsdsssfully']);
  }

  public function addmarkuser($emailluser)
  {
    $users = Assign::where('email', $emailluser)
    ->where('teacher_id', '=', Auth::id())
    ->get();
    return view('admin.markshow', compact(['users']));
  }


  public function assignmark($emailluser, $corse)
  {
    return view('admin.addmark', compact(['emailluser', 'corse']));
  }

  public function addnmark(Request $request)
  {
    $BaseMark = Product::where('teacher_id', '=', Auth::id())
      ->where('Name', '=', $request->Course)
      ->select('Base_Mark')
      ->get();
    if ($BaseMark->isEmpty()) {
      return response()->json([
        'success' => false,
        'errors' => 'This teacher does not own this course.'
      ], 422);
    }
    $baseMarkValue = $BaseMark->first()->Base_Mark;
    if ($baseMarkValue < $request->Base_Mark) {
      return response()->json([
        'success' => false,
        'errors' => 'The base mark is less than the student mark.'
      ], 422);
    }
    $data = Assign::where('Email', $request->Email)
      ->where('Course', $request->Course)
      ->update(['Base_Mark' => $request->Base_Mark]);
    if ($data) {
      session()->flash('success', 'Mark Add Successful');
      return response()->json(['redirect_url' => route("admin/show")]);
    }
  }
  public function showcorse($data)
  {
    $data = Assign::where('email', '=', value: $data)->get();
    if ($data->isNotEmpty()) {
      session()->flash('show_table');
    }
    return view('showuser');
  }
  public function getuser(Request $request, $email)
  {
    $data = DB::table('Assigns')
    ->join('Products', function($join) {
        $join->on('Assigns.Course', '=', 'Products.Name')
             ->whereColumn('Assigns.teacher_id', '=', 'Products.teacher_id');
    })
    ->where('Assigns.email', $email)
    ->select(
        'Assigns.Course AS Course',
        'Assigns.Base_Mark AS markuser',
        'Products.Pass_Mark AS Passmark',
        'Products.Base_Mark AS Basemark'
    )
    ->get();
    if ($data->isNotEmpty()) {
      session()->flash('show_table');
    }
    return datatables()->of($data)
      ->addColumn('Result', function ($row) {
        if ($row->markuser < $row->Passmark) {
          return "<span style='color:red'>Failed</span>";
        } else {
          return "<span style='color:green'>Successful</span>";
        }
      })
      ->rawColumns(['Result'])
      ->make(true);
  }
}
