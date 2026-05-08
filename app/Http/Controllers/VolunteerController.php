<?php

namespace App\Http\Controllers;

use App\Models\State;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class VolunteerController extends Controller
{
    public function create(): View
    {
        return view('volunteers.create', [
            'states' => State::query()->orderBy('name_ar')->get(),
            'skills' => $this->skills(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['required', 'string', 'max:30'],
            'state_id' => ['required', Rule::exists('states', 'id')],
            'skills' => ['required', 'array', 'min:1'],
            'skills.*' => ['string', Rule::in(array_keys($this->skills()))],
            'motivation' => ['required', 'string', 'min:60', 'max:3000'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'agreed_to_manifesto' => ['accepted'],
        ], [
            'skills.required' => 'اختر مجال مساهمة واحداً على الأقل.',
            'motivation.min' => 'نحتاج نبذة أوضح عن رغبتك في المساهمة، لا تقل عن 60 حرفاً.',
            'agreed_to_manifesto.accepted' => 'يلزم الموافقة على ميثاق المساهمة قبل إرسال الطلب.',
        ]);

        User::create([
            'state_id' => $validated['state_id'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'password' => $validated['password'],
            'role' => 'ambassador',
            'bio' => $validated['motivation'],
            'volunteer_skills' => $validated['skills'],
            'application_status' => 'pending',
            'is_active' => false,
        ]);

        return redirect()
            ->route('volunteer.create')
            ->with('success', 'تم استلام طلب الانضمام بنجاح. سيقوم فريق الإدارة بمراجعته والتواصل معك عند التفعيل.');
    }

    private function skills(): array
    {
        return [
            'history' => 'التاريخ والآثار',
            'photography' => 'التصوير والجولات 360',
            'investment' => 'فرص الاستثمار',
            'services' => 'دليل الخدمات',
            'culture' => 'الثقافة والشخصيات',
            'community' => 'التنسيق المجتمعي',
        ];
    }
}
