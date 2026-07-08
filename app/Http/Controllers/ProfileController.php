<?php

namespace App\Http\Controllers;

use App\Models\AccountantProfile;
use App\Models\AdminProfile;
use App\Models\ReceptionProfile;
use App\Models\StudentDetail;
use App\Models\SuperAdminProfile;
use App\Models\TeacherProfile;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function profileview()
    {
        $profileData = Auth::user();
        if ($profileData->status == '0') {
            Auth::logout();
            return redirect(route('login'))->with(['status' => 'suspend']);
        }
        return view('backend.body.profile', compact('profileData'));
    }

    public function ProfileUpdate(Request $request)
    {
        $user = Auth::user();
        $profileData = User::find($user->id);
        $profileData->name = $request->profileName;
        $profileData->email = $request->email;
        if ($user->role == 'admin') {
            $adminProfile = AdminProfile::where('role_id',$user->id)->first();
            if ($request->file('photo')) {
                $file = $request->file('photo');
                @unlink(public_path('uploads/adminimages/' . $adminProfile->photo));
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('uploads/adminimages'), $filename);
                $adminProfile['photo'] = $filename;
            }
            $adminProfile->phone = $request->phone;
            $adminProfile->save();
        }elseif ($user->role == 'teacher') {
            $teacherProfile = TeacherProfile::where('role_id',$user->id)->first();
            if ($request->file('photo')) {
                $file = $request->file('photo');
                @unlink(public_path('uploads/teacherimages/' . $teacherProfile->photo));
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('uploads/teacherimages'), $filename);
                $teacherProfile['photo'] = $filename;
            }
        }elseif ($user->role == 'student') {
            $studentProfile = StudentDetail::where('role_id',$user->id)->first();
            if ($request->file('photo')) {
                $file = $request->file('photo');
                @unlink(public_path('./uploads/studentimages/' . $studentProfile->student_photo));
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('/uploads/studentimages'), $filename);
                $studentProfile->student_photo = $filename;
                $studentProfile->save();
            }    
        }elseif ($user->role == 'reception') {
            $receptionistProfile = ReceptionProfile::where('role_id',$user->id)->first();
            if ($request->file('photo')) {
                $file = $request->file('photo');
                @unlink(public_path('uploads/receptionistimages/' . $receptionistProfile->photo));
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('uploads/receptionistimages'), $filename);
                $receptionistProfile['photo'] = $filename;
            } 
            $receptionistProfile->phone = $request->phone;
            $receptionistProfile->save();   
        }elseif ($user->role == 'accountant') {
            $accountantProfile = AccountantProfile::where('role_id',$user->id)->first();
            if ($request->file('photo')) {
                $file = $request->file('photo');
                @unlink(public_path('uploads/accountantimages/' . $accountantProfile->photo));
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('uploads/accountantimages'), $filename);
                $accountantProfile['photo'] = $filename;
            }
            $accountantProfile->phone = $request->phone;
            $accountantProfile->save();
        }else{
            $superadminProfile = SuperAdminProfile::where('role_id',$user->id)->first();
            if ($request->file('photo')) {
                $file = $request->file('photo');
                @unlink(public_path('uploads/superadminimages/' . $superadminProfile->photo));
                $filename = date('YmdHi') . $file->getClientOriginalName();
                $file->move(public_path('uploads/superadminimages'), $filename);
                $superadminProfile['photo'] = $filename;
            }
            $superadminProfile->phone = $request->phone;
            $superadminProfile->save();
        }
        $profileData->save();
        $notification = array(
            'message' => 'Profile Updated Successfully',
            'alert-type' => 'success'
        );
        return redirect(route('profile'))->with('profileData')->with($notification);
    }

    public function passwordview()
    {
        $profileData = Auth::user();
        if ($profileData->status == '0') {
            Auth::logout();
            return redirect(route('login'))->with(['status' => 'suspend']);
        }
        return view('backend.body.changepassword');
    }
    public function passwordupdate(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|confirmed',
        ]);

        if (!Hash::check($request->old_password, auth::user()->password)) {

            $notification = array(
                'message' => 'Old Password Does not Match!',
                'alert-type' => 'error'
            );
            return back()->with($notification);
        }

        User::whereId(auth::user()->id)->update([
            'password' => Hash::make($request->new_password)
        ]);

        $notification = array(
            'message' => 'Password Change Successfully',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }
    public function parentLogin()
    {
        return view('auth.parentlogin');
    }
    public function parentLoginStore(Request $request)
    {
        $request->validate([
            'cnic' => 'required|max:15',
            'password' => 'required',
        ]);
        $user = User::where('cnic', $request->cnic)->first();
        if (!$user) {
            return redirect()->back()->with(['user' => 'no-user']);
        } else {
            if (Hash::check($request->password, $user->password) && $user->role == 'student') {
                Auth::login($user);
                $request->session()->regenerate();
                $notification = [
                    'alert-type' => 'success',
                    'message' => 'Parent Logged in successfully!'
                ];
                return redirect(route('parent.dashboard'))->with($notification);
            } else {
                return redirect()->back()->with(['login' => 'invalid']);
            }
        }

    }
}
