<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function loginPost(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials)) {
            return redirect()->route('product.index');
        }
        return back()->with('error', 'Incorrect email and password');
    }

    public function register()
    {
        $institutes = ["Air University, Islamabad", "Allama Iqbal Open University, Islamabad (AIOU)", "Bahria University, Islamabad", "COMSATS Institute of Information Technology, Islamabad", "Dawood University of Engineering & Technology, Karachi", "Federal Urdu University of Arts, Sciences & Technology, Islamabad", "Institute of Space Technology, Islamabad (IST)", "International Islamic University, Islamabad", "Karakurum International University, Gilgit, Gilgit Baltistan", "National College of Arts, Lahore (NCA)", "National Defense University, Islamabad (NDU)", "National Textile University, Faisalabad", "National University of Modern Languages, Islamabad (NUML)", "National University of Sciences & Technology, Rawalpindi/ Islamabad (NUST)", "National University of Medical Sciences, Islamabad", "NFC Institute of Engineering", "Technology, Multan", "Pakistan Institute of Development Economics (PIDE), Islamabad", "Pakistan Institute of Engineering & Applied Sciences, Islamabad (PIEAS)", "Pakistan Institute of Fashion and Design, Lahore", "Pakistan Military Academy, Abbottabad (PMA)", "Pakistan Naval Academy, Karachi", "Shaheed Zulfiqar Ali Bhutto Medical University, Islamabad", "Quaid-i-Azam University, Islamabad", "University of FATA, Kohat", "Virtual University of Pakistan, Lahore", "Bahauddin Zakariya University, Multan", "Fatima Jinnah Women University, Rawalpindi", "Government College University, Faisalabad", "Government College University, Lahore", "Government College for Women University, Faisalabad", "Ghazi University, Dera Ghazi Khan", "Government College for Women University, Sialkot", "Government Sadiq College Women University, Bahawalpur", "Islamia University, Bahawalpur", "Information Technology University of the Punjab, Lahore", "King Edward Medical University, Lahore", "Kinnaird College for Women, Lahore", "Khawaja Freed University of Engineering & Information Technology, Rahim Yar Khan", "Lahore College for Women University, Lahore", "Muhammad Nawaz Shareef University of Agriculture, Multan", "Pir Mehr Ali Shah Arid Agriculture, University Rawalpindi", "University of Agriculture, Faisalabad", "University of Education, Lahore", "University of Engineering & Technology, Lahore", "University of Engineering & Technology, Taxila", "University of Gujrat, Gujrat", "University of Health Sciences, Lahore", "University of Sargodha, Sargodha", "University of the Punjab, Lahore", "University of Veterinary & Animal Sciences, Lahore", "The Women University, Multan", "Muhammad Nawaz Sharif University", "Engineering & Technology, Multan", "Benazir Bhutto Shaheed University Lyari, Karachi", "DOW University of Health Sciences, Karachi", "Gambat Institute of Medical Sciences, Khairpur", "Institute of Business Administration, Karachi", "Jinnah Sindh Medical University", "Liaquat University of Medical and Health Sciences, Jamshoro Sindh.", "Mehran University of Engineering & Technology, Jamshoro", "NED University of Engineering & Technology, Karachi", "Peoples University of Medical and Health Sciences for Women, Nawabshah (Shaheed Benazirabad)", "Quaid-e-Awam University of Engineering, Sciences & Technology, Nawabshah", "Shah Abdul Latif University, Khairpur", "Shaheed Mohtarma Benazir Bhutto Medical University, Larkana", "Sindh Agriculture University, Tandojam", "Sukkur Institute of Business Administration, Sukkur", "Sindh Madresatul Islam University, Karachi", "Shaheed Benazir Bhutto University Shaheed Benazirabad", "Shaheed Zulfiqar Ali Bhutto University of Law, Karachi", "University of Karachi, Karachi", "University of Sindh, Jamshoro", "Shaheed Benazir Bhutto University of Veterinary And Animal Sciences Sakrand", "Abdul Wali Khan University, Mardan", "Bacha Khan University, Charsadda", "Frontier Women University, Peshawar", "Gomal University, D.I. Khan", "Hazara University, Dodhial, Mansehra", "Institute of Management Science, Peshawar (IMS)", "Islamia College University, Peshawar", "Khyber Medical University, Peshawar", "Kohat University of Science and Technology, Kohat", "Khushal Khan Khattak University, Karak", "Khyber Pakhtunkhwa Agricultural University, Peshawar", "University of Engineering & Technology, Peshawar", "Shaheed Benazir Bhutto University, Sheringal, Dir", "University of Malakand, Chakdara, Dir, Malakand", "University of Peshawar, Peshawar", "University of Science & Technology, Bannu", "University of Swat, Swat", "University of Haripur, Haripur", "University of Swabi", "University of Swabi for Women, Swabi", "Balochistan University of Engineering & Technology, Khuzdar", "Balochistan University of Information Technology & Management Sciences, Quetta", "Lasbela University of Agriculture, Water and Marine Sciences", "Sardar Bahadur Khan Women University, Quetta", "University of Balochistan, Quetta", "University of Turbat, Turbat", "University of Loralai, Loralai", "Mirpur University of Science and Technology (MUST), AJ&K", "University of Azad Jammu & Kashmir, Muzaffarabad, Azad Kashmir, Muzaffarabad", "University of Poonch, Rawalakot", "Women University of Azad Jammu and Kashmir Bagh", "University of Management Sciences and Information Technology, Kotli", "Aga Khan University, Karachi", "Capital University of Science and Technology, Islamabad", "Foundation University, Islamabad", "Lahore University of Management Sciences (LUMS), Lahore", "MY University, Islamabad", "FAST National University of Computer and Emerging Sciences, Islamabad Campus", "Riphah International University, Islamabad", "Shifa Tameer-e-Millat University, Islamabad", "Ali Institute of Education", "Beaconhouse National University, Lahore", "Forman Christian College, Lahore (university status)", "Global Institute, Lahore", "Hajvery University, Lahore", "HITEC University, Taxila", "Imperial College of Business Studies, Lahore", "Institute of Management Sciences, Lahore", "Institute of Southern Punjab, Multan", "Lahore Leads University, Lahore", "Lahore School of Economics, Lahore", "Lahore Garrison University, Lahore", "Minhaj University, Lahore", "National College of Business Administration & Economics, Lahore", "Nur International University, Lahore", "Qarshi University", "The GIFT University, Gujranwala", "The Superior College, Lahore", "The University of Faisalabad, Faisalabad", "University of Central Punjab, Lahore", "University of Lahore, Lahore", "University of Management & Technology, Lahore", "University of South Asia, Lahore", "University of Wah, Wah", "Baqai Medical University, Karachi", "Commecs Institute of Business & Emerging Sciences, Karachi", "Dadabhoy Institute of Higher Education,Karachi", "DHA Suffa University, Karachi", "Greenwich University, Karachi", "Hamdard University, Karachi", "Habib University, Karachi", "Indus University, Karachi", "Indus Valley School of Art and Architecture, Karachi", "Institute of Business Management, Karachi", "Institute of Business and Technology, Karachi", "Iqra University, Karachi", "Isra University, Hyderabad", "Jinnah University for Women, Karachi", "Karachi Institute of Economics & Technology, Karachi", "KASB Institute of Technology, Karachi", "Karachi School for Business & Leadership", "Muhammad Ali Jinnah University, Karachi", "Newport Institute of Communications & Economics, Karachi", "Preston Institute of Management, Science and Technology, Karachi", "Preston University, Karachi", "Shaheed Zulfikar Ali Bhutto Institute of Sc. & Technology (SZABIST), Karachi", "Shaheed Benazir Bhutto City University, Karachi", "Sir Syed University of Engg. & Technology, Karachi", "Sindh Institute of Medical Sciences, Karachi", "Sindh Institute of Management and Technology, Karachi", "Textile Institute of Pakistan, Karachi", "The Nazeer Hussian University, Karachi", "Zia-ud-Din University, Karachi", "Shaheed Benazir Bhutto Dewan University, Karachi", "Abasyn University, Peshawar", "CECOS University of Information Technology and Emerging Sciences, Peshawar", "City University of Science and Information Technology, Peshawar", "Gandhara University, Peshawar", "Ghulam Ishaq Khan Institute of Engineering Sciences & Technology, Topi", "Iqra National University, Peshawar", "Northern University, Nowshera", "Preston University, Kohat", "Qurtaba University of Science and Information Technology, D.I. Khan", "Sarhad University of Science and Information Technology, Peshawar", "Al-Hamd Islamic University, Quetta", "Mohi-ud-Din Islamic University, AJK"];
        $data = compact('institutes');
        return view('auth.register')->with($data);
    }
    public function registerPost(Request $request)
    {
        $checkEmail = User::where('email', $request->email)->first();
        if ($checkEmail) {
            return back()->with('error', 'Email already exists');
        }

        $request->validate(
            [
                'hei_name' => 'required',
                'rep_name' => 'required',
                'rep_designation' => 'required',
                'email' => 'required',
                'username' => 'required',
                'rep_phone' => 'required',
                'rep_sec_phone' => 'required',
                'password' => 'required|confirmed',
                'password_confirmation' => 'required',
                'terms' => 'required'
            ],
            [
                'hei_name.required' => 'Higher Education Institution Name is required.',
                'rep_name.required' => 'Representative Name is required.',
                'rep_designation.required' => 'Representative Designation is required.',
            ]
        );

        $user = new User;
        $user->hei_name = $request['hei_name'];
        $user->rep_name = $request['rep_name'];
        $user->rep_designation = $request['rep_designation'];
        $user->email = $request['email'];
        $user->username = $request['username'];
        $user->rep_phone = $request['rep_phone'];
        $user->rep_sec_phone = $request['rep_sec_phone'];
        $user->password = Hash::make($request['password']);
        $user->save();

        $credentials = [
            'email' => $user->email,
            'password' => $request->password,
        ];

        Auth::attempt($credentials);

        return redirect()->route('profile.index')->with('success', 'Congratulations, account created please login for access');
    }

    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
