<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use App\Models\Institute;
use App\Models\User;
use App\Models\InstituteUser;
use App\Models\UserPhone;
use App\Models\InstituteContact;
use App\Models\SthubFile;
use App\Services\simple_html_dom;
use App\Http\Requests\UpdateInstituteBlogRequest;
use App\Http\Requests\UpdateInstituteRequest;
use App\Http\Requests\UpdateStudentRequest;
use App\Http\Requests\AddAdminDetailsRequest;
use App\Http\Requests\UpdateInstituteContactRequest;
use App\Http\Requests\SaveBannerRequest;
use App\Http\Requests\CreateRequest;
class InstituteController extends Controller
{
    //

    public function index(Request $request)
    {
        $in_query = DB::table('institutes as ins');
        if(!empty($request->searchTerm)){
            $input = $request->searchTerm;
            $in_query = $in_query->where('ins.name', 'LIKE', $input . '%')
            ->orWhere('ins.alias', 'LIKE', $input . '%');
        }
        $institutes = $in_query->leftJoin('students as st', 'ins.id', '=', 'st.institute_id')
        ->select('ins.id', 'ins.name', DB::raw("COUNT('st.id') as totalStudent"))
        ->groupBy('ins.id', 'ins.name')
        ->orderBy('totalStudent', 'DESC')->limit(10)->get();

        return response()->json(['success' => [
            'institutes' => $institutes
        ]]);
    }
    public function show($instituteId=null, Request $request)
    {
        if($instituteId){
            $institute = Institute::findOrFail($instituteId);
        }else if($request->user('api')){
            $institute=Institute::findOrFail($request->user('api')->preferred_institute_id);
        }

        if(empty($institute)){
            abort(404);
        }
        $teachers = User::where('role','teacher')
        ->where('preferred_institute_id',$institute->id)
        ->with('preferredCourse')
        ->get();

        $students = User::where('role','student')
        ->where('preferred_institute_id',$institute->id)
        ->with('preferredCourse')
        ->get();

        
        return response()->json(['success'=>[
            'institute'=>$institute,
            'teachers'=>$teachers,
            'students'=>$students,
        ]]);
    
    }
    public function showusers($instituteId = null, Request $request)
    {
        if ($instituteId) {
            $institute = Institute::findOrFail($instituteId);
        } else if ($request->user('api')) {
            $institute = Institute::findOrFail($request->user('api')->preferred_institute_id);
        }

        if (empty($institute)) {
            abort(404);
        }

        $institute_users = DB::table('institute_users as inst')->where('inst.institute_id', $institute->id)
        ->where('inst.role', '!=', 'teacher')
        ->leftJoin('institutes as in', 'in.id', '=', 'inst.institute_id')
        ->leftjoin('users as us', 'us.id', '=', 'inst.user_id')
        ->select(['inst.id as id', 'in.id as institute_id', 'inst.user_id as user_id', 'inst.role as role', 'us.full_name as user_name'])
        ->get();

        $institute_contacts = DB::table('institute_contactus as inct')->where('inct.institute_id', $institute->id)
        ->leftJoin('institutes as in', 'in.id', '=', 'inct.institute_id')
        ->select(['inct.id as id', 'in.id as institute_id', 'inct.department as department', 'inct.email as email',
         'inct.phone_no as phone_no', 'inct.phone_no2 as phone_no2', 'inct.whatsapp_no as whatsapp_no'])
        ->get();
        return response()->json(['success' => [
                'institute' => $institute,
                'institute_users' => $institute_users,
                'institute_contacts' => $institute_contacts,
            ]]);
    }


    public function showAdmin($instituteId){
        $institute_detail = Institute::findOrFail($instituteId);

        $members=DB::table('institute_users as inu')->where('inu.institute_id',$instituteId)
        ->join('users as us','us.id','=','inu.user_id')
        ->select('us.id','us.full_name','us.email','inu.role')
        ->get();

        $teachers=DB::table('classrooms as cls')->where('cls.institute_id',$instituteId)
        ->leftJoin('users as us','cls.teacher_user_id','=','us.id')
        ->leftJoin('daily_assignments as da','da.classroom_id','=','cls.id')
        ->leftJoin('daily_reports as dr','dr.daily_assignment_id','=','da.id')
        ->select('us.id','us.full_name','us.email',
        DB::raw('AVG(dr.marks_obtained) as avg_score'),
        DB::raw('COUNT(distinct cls.id) as total_classrooms')
        )
        ->groupBy('us.id','us.full_name','us.email')
        ->get();

        $students=DB::table('students as st')->where('st.institute_id',$instituteId)
        ->join('users as us','us.id','=','st.user_id')
        ->join('courses as cs','cs.id','=','st.course_id')
        ->leftJoin('daily_reports as dr','dr.user_id','=','us.id')
        ->select('us.id','us.full_name','us.email','st.unique_college_id as institute_id','cs.alias as course_alias',
        DB::raw('AVG(dr.marks_obtained) as avg_score')
        )
        ->groupBy('us.id','us.full_name','us.email','st.unique_college_id','cs.alias')
        ->get();


        $classrooms = DB::table('classrooms as cl')
        ->where('cl.institute_id',$instituteId)
        ->leftjoin('classroom_users','classroom_users.classroom_id','=','cl.id')
        ->leftjoin('daily_assignments','cl.id','=','daily_assignments.classroom_id')
        ->leftjoin('users','cl.teacher_user_id','=','users.id')
        ->leftjoin('subjects','cl.subject_id','=','subjects.id')
        ->leftjoin('classroom_resources','cl.id','=','classroom_resources.classroom_id')
        ->leftjoin('messages','cl.id','=','messages.classroom_id')
        ->leftjoin('daily_reports','daily_assignments.id','=','daily_reports.daily_assignment_id')
        ->select(DB::raw('COUNT(classroom_resources.id) as total_resources'),
                'subjects.subject_name as subject_name',
                'users.full_name AS teacher_name',
                'cl.classroom_join_id as join_id',
                'cl.id as classroom_id',
                'cl.name as classroom_name',
                DB::raw('COUNT(distinct classroom_users.user_id) AS total_students'),
                DB::raw('COUNT(distinct daily_assignments.id) AS total_daily_assignments'),
                DB::raw('FORMAT(AVG(daily_reports.marks_obtained),2) as average_score')
                )
        ->groupBy('cl.id','users.full_name','subjects.subject_name','cl.name','cl.classroom_join_id')
        ->get();

        $batches = DB::table('classrooms as cl')
        ->where('cl.institute_id',$instituteId)
        ->leftjoin('classroom_users','classroom_users.classroom_id','=','cl.id')
        ->leftjoin('daily_assignments','cl.id','=','daily_assignments.classroom_id')
        ->leftjoin('daily_reports','daily_assignments.id','=','daily_reports.daily_assignment_id')
        ->select(
                'cl.name as name',
                DB::raw('COUNT(distinct cl.id) AS total_classrooms'),
                DB::raw('COUNT(distinct daily_assignments.id) AS total_daily_assignments'),
                DB::raw('FORMAT(AVG(daily_reports.marks_obtained),2) as average_score')
                )
        ->groupBy('cl.name')
        ->get();
        
        return response()->json([
            'success'=>[
                'institute_detail'=>$institute_detail,
                'members'=>$members,
                'students'=>$students,
                'classrooms'=>$classrooms,
                'batches'=>$batches,
                'teachers'=>$teachers,
            ]
        ],200);
    }

    public function adminIndex()
    {
        $institutes=DB::table('institutes as in')
        ->leftJoin('students as st','st.institute_id','=','in.id')
        ->select('in.*',
            DB::raw('COUNT(DISTINCT st.user_id) AS student_count'),
        )
        ->groupBy('in.id')
        ->get();

        return response()->json([
            'success'=>[
                'institutes'=>$institutes
            ]
        ],200);
    }

    //only admin access
    public function create(CreateRequest  $request){
        $institute=Institute::create([
            'name'=>$request->form_data['client_name'],
            'added_by_user_id'=>Auth::id(),
            'is_verified'=>true,
        ]);

        return response()->json(['success'=>[
            'institute_id'=>$institute->id
        ]]);
    }

    public function indexStudents()
    {
        $instituteId = Auth::user()->preferred_institute_id;
        $students=DB::table('students as st')->where('st.institute_id',$instituteId)
        ->join('users as us','us.id','=','st.user_id')
        ->join('courses as cs','cs.id','=','st.course_id')
        ->leftJoin('daily_reports as dr','dr.user_id','=','us.id')
        ->select('us.id','us.full_name','us.email','st.unique_college_id as institute_id','cs.alias as course_alias',
        DB::raw('AVG(dr.marks_obtained) as avg_score')
        )
        ->groupBy('us.id','us.full_name','us.email','st.unique_college_id','cs.alias')
        ->get();


        return response()->json(['success'=>[
            'students'=>$students,
        ]]);

    }
    public function showStudent(User $user)
    {
        if(!Auth::user()->isStaff()){
            abort(401);
        }
        $student_detail=DB::table('users as us')->where('us.id',$user->id)
        ->leftJoin('user_parents as pa','pa.user_id','=','us.id')
        ->leftJoin('users as pus','pus.id','=','pa.parent_user_id')
        ->select('us.full_name','us.email',
        'pus.full_name as parent_name','pus.id as parent_id','pus.email as parent_email','pus.phone_no as parent_phone')
        ->first();


        return response()->json(['success'=>[
            'student_detail'=>$student_detail,
        ]]);

    }

    public function updateStudent(UpdateStudentRequest  $request, User $user)
    {
        
        $parent = null;
        if ($request->parent_id){
            $parent = User::findOrFail($request->parent_id);
        }else{
            $parent = new User;
            $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()";
            $parent->password=Hash::makes(substr(str_shuffle($chars),0,8));
        }
        $parent->full_name=$request->parent_name;
        $parent->email=preg_replace('/\s+/', '',$request->parent_email);
        $parent->phone_no=preg_replace('/\s+/', '',$request->parent_phone);
        $parent->role='parent';
        $parent->preferred_institute_id=$request->user('api')->preferred_institute_id;
        $parent->save();

        \App\Models\UserParent::firstOrCreate([
            'parent_user_id'=>$parent->id,
            'user_id'=>$user->id,
        ]);

        return response()->json([], 204);
    }
    public function addAdminiDetails(AddAdminDetailsRequest $request){

        
        $instituteId = Auth::user()->preferred_institute_id;
        $otp = rand(11111,99999);

        $user_phone =new UserPhone;
        $user_phone->phone_no =$request->phone_no;
        $user_phone->expires_at = Carbon::now()->toDateTimeString();
        $user_phone->otp =Hash::make($otp);
        $user_phone->save();

        $user =new User;
        $user->phone_id =$user_phone->id;
        $user->full_name =$request->name;
        $user->role =$request->role;
        $user->save();

        $institute_user =new InstituteUser;
        $institute_user->user_id =$user->id;
        $institute_user->institute_id =$instituteId;
        $institute_user->role=$user->role;
        $institute_user->save();

        return response()->json(['success'=>[
            'institute_user'=> $institute_user,
        ]]);
    }
    public function delete ($instituteuser_id)
    {
        $institute_user = InstituteUser::find($instituteuser_id);
        $institute_user->delete();
        return 'success';
    }
    public function addOrUpdate(UpdateInstituteContactRequest $request){

        $request -> validated();
        $instituteId = Auth::user()->preferred_institute_id;
        if($request->edit_institute_contact_id){
            $institute_contacts = InstituteContact::find($request->edit_institute_contact_id);
        }
        else{
            $institute_contacts = new InstituteContact();
        }
            $institute_contacts->email = $request->email;
            $institute_contacts->phone_no = $request->phone_no;
            $institute_contacts->phone_no2 =$request->phone_no2;
            $institute_contacts->whatsapp_no=$request->whatsapp_no;
            $institute_contacts->department =$request->department;
            $institute_contacts->institute_id = $instituteId;
            $institute_contacts->save();

           
            return response()->json(['success'=>[
                'institute_contacts'=> $institute_contacts,
            ]]);
    }
    public function deleteContact($contact_id)
    {
        $institute_contacts = InstituteContact::find($contact_id);
        $institute_contacts->delete();
        return 'success';
    }
    public function addOrUpdateInstitute(UpdateInstituteRequest $request)
    {
        if($request->id){
            $institute=Institute::findOrFail($request->id);
        } else {
            $institute = new Institute();
            $institute->name = $request->name;
            $institute->added_by_user_id = $request->user('api')->id; 
        }

        // if($request->banner_pic){
        //     $image = $request->banner_pic; // image base64 encoded
        //     preg_match("/data:image\/(.*?);/",$image,$image_extension); // extract the image extension
        //     $image = preg_replace('/data:image\/(.*?);base64,/','',$image); // remove the type part
        //     $image = str_replace(' ', '+', $image);
        //     $file_name = 'image_' . time() . '.' . $image_extension[1]; //generating unique file name;
        //     \Storage::disk('institute-image')->put($file_name,base64_decode($image));
        //     $institute->institute_url="/storage/institute-institute-images/".$file_name;
        //     $institute->save();
        //     $newFile= new SthubFile();
        //     $newFile->fileable_id=$me->id;
        //     $newFile->fileable_type=Institute::class;
        //     $newFile->file_ext=Storage::disk('institute-profile-image')->getMimeType($file_name);
        //     $newFile->file_size=Storage::disk('institute-profile-image')->size($file_name);
        //     $newFile->file_name=$file_name;
        //     $newFile->user_id=$me->id;
        //     $newFile->save();
        // }
        
        if($request->fb_url){
            $institute->fb_url=$request->fb_url;
        }
        if($request->twitter_url){
            $institute->twitter_url=$request->twitter_url;
        }
        if($request->insta_url){
            $institute->insta_url=$request->insta_url;
        }
        if($request->linkedin_url){
            $institute->linkedin_url=$request->linkedin_url;
        }
        if($request->youtube_vedio_url){
            $institute->youtube_vedio_url=$request->youtube_vedio_url;
        }
        $institute->website =$request->website;
        $institute->address =$request->address;
        $institute->city =$request->city;
        $institute->state =$request->state;
        $institute->moto =$request->moto;
       
        $institute->save();
        return response()->json(['success'=>[
            'institute'=>$institute
        ]]);
    }

    public function savebanner(SaveBannerRequest $request){

        
        
        $me=$request->user('api');
        $banner=Institute::where('added_by_user_id',$me->id)->first();
        dd('xyz',$request->all());
           
        if($request->banner_pic){
            $image = $request->banner_pic; // image base64 encoded
            preg_match("/data:image\/(.*?);/",$image,$image_extension); // extract the image extension
            $image = preg_replace('/data:image\/(.*?);base64,/','',$image); // remove the type part
            $image = str_replace(' ', '+', $image);
            $file_name = 'image_' . time() . '.' . $image_extension[1]; //generating unique file name;
            Storage::disk('profile-image')->put($file_name,base64_decode($image));
            $banner->profile_url="/storage/institute-profile-images/".$file_name;
            $banner->save();
            $newFile= new SthubFile();
            $newFile->fileable_id=$me->id;
            $newFile->fileable_type=Institute::class;
            $newFile->file_ext=Storage::disk('institute-profile-image')->getMimeType($file_name);
            $newFile->file_size=Storage::disk('institute-profile-image')->size($file_name);
            $newFile->file_name=$file_name;
            $newFile->user_id=$me->id;
            $newFile->save();
        }
        
        //$banner->profile_url =$request->banner_pic;
        $banner->save();
        return response()->json(['success'=>[
            'banner'=>$banner
        ]]);
    }
    public function updateInstituteBlog(Institute $institute,UpdateInstituteBlogRequest $request) {

        $request -> validated();
        $institute->blog = '';

        $simple_html_dom = new simple_html_dom;
        $dom = $simple_html_dom->extactImageFiles($request->new_blog, "institute-blog-image");
        
        $institute->blog = $dom->html;
        $institute->save();

        foreach($dom->files as $file){
            $newFile= new SthubFile();
            $newFile->fileable_id=$institute->id;
            $newFile->fileable_type=Institute::class;
            $newFile->file_ext=Storage::disk('institute-blog-image')->getMimeType($file);
            $newFile->file_size=Storage::disk('institute-blog-image')->size($file);
            $newFile->file_name=$file;
            $newFile->user_id=$request->user('api')->id;
            $newFile->save();
        }

        return response()->json([], 204);
    }
}
