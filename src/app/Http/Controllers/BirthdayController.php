<?php

namespace App\Http\Controllers;

use DateTime;
use DateTimeZone;
use Response;

use App\Utils\TimeTillAnniversary;
use App\Models\Birthdays;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class BirthdayController extends Controller
{
    public function list(Request $request){
        $validator = Validator::make($request->all(), [
            'now' => 'date',
            'tz' => 'timezone',
        ]);
        if ($validator->fails()) {
            return Response::json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 406);
        }
        $input = $validator->valid();
        $tz = new DateTimeZone($input['tz'] ?? 'America/Los_Angeles');
        $now = new DateTime($input['now'] ?? 'now', $tz);

        $birthdays = Birthdays::select('name', 'birthdate', 'tz')->paginate(50);

        foreach ($birthdays as $birthday) {
            $tillAnniversary = new TimeTillAnniversary($birthday->birthdate, $birthday->tz, $now);
            $birthday['isBirthday'] = $tillAnniversary->isToday();
            $birthday['interval'] = $tillAnniversary->raw();
            $birthday['message'] = $birthday->name . ' is ' . $tillAnniversary->ageAtAnniversary()
                . ' years old ' . str($tillAnniversary);
        }

        return Response::json(array_merge($birthdays->toArray(), ['success' => true]), 200);
    }

    public function add(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:100',
            'birthdate' => 'required|date',
            'tz' => 'required|timezone',
        ]);
        if ($validator->fails()) {
            return Response::json([
                'success' => false,
                'errors' => $validator->errors(),
            ], 200); // could be 406 to be more proper but using 200 for simplicity of ajax
        }
        $data = $validator->valid();

        try {
            Birthdays::create([
                'name' => $data['name'], 
                'birthdate' => $data['birthdate'], 
                'tz' => $data['tz'],
            ]);
        } catch (\Exception $e) {
            return Response::json([
                'success' => false,
                'errors' => ['save' => $e->getMessage()],
            ], 500);            
        }

        return Response::json(['success' => true], 200);
    }
}
