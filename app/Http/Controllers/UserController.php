<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\StoreRequest;
use App\Models\User;

//use http\Env\Request;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Arr;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $requestTemp = $request->all();
        $validationMessages = validator($requestTemp, [
            'page' => 'integer|min:1',
            'count' => 'integer|min:1|max:100',
        ])->errors()->messages();

        if ($validationMessages) {
            return response(['success' => false, 'message' => 'Validation failed', 'fails' => $validationMessages], 422);
        }

        $totalUsers = User::all()->count();
        if (Arr::get($requestTemp, 'page')) {
            $page = $requestTemp['page'];
        } elseif (!Arr::get($requestTemp, 'page')) {
            $page = 1;
        }
        if (Arr::get($requestTemp, 'count')) {
            $count = $requestTemp['count'];
        } elseif (!Arr::get($requestTemp, 'count')) {
            $count = 6;
        }

        if ($totalUsers % $count != 0) {
            $totalPages = ($totalUsers / $count) + 1;
        } else {
            $totalPages = $totalUsers / $count;
        }

        $links = ['next_url' => $page == (int)$totalPages ? null : url()->current() . '?page=' . $page + 1 . '&count=' . $count,
            'prev_url' => $page == 1 ? null : url()->current() . '?page=' . $page - 1 . '&count=' . $count];
        $usersOnPageTemp = User::all()
            ->skip($page == 1 ? 0 : $page * $count - $count)
            ->take($count)->all();
        $usersOnPage = [];
        foreach ($usersOnPageTemp as $userOnPage) {
            $positionName = $userOnPage->position->name;
            Arr::except($userOnPage, 'position');
            $userOnPage['position'] = $positionName;
            $usersOnPage[] = $userOnPage;
        }
        if ((int)$page > (int)$totalPages) {
            return response([
                'success' => false,
                'message' => 'Page not found',
            ], 404);
        }
        return response([
            'success' => true,
            'page' => $page,
            'total_pages' => (int)$totalPages,
            'total_users' => $totalUsers,
            'count' => $count,
            'links' => $links,
            'users' => $usersOnPage
        ], 200);
//        return User::paginate(6);
    }

    public function store(Request $request)
    {
        $requestTemp = $request->all();
        $requestTemp += ['token' => $request->bearerToken()];
        $validationMessages = validator($requestTemp, [
            'name' => 'required|min:2|max:60',
            'email' => 'required|min:2|max:100|email|unique:users',
            'phone' => "required|unique:users|regex:'^[\+]{0,1}380([0-9]{9})$'",
            'position_id' => 'required|integer|exists:positions,id|min:1',
            'password' => 'required',
            'photo' => 'required|file|max:5120|mimes:jpeg,jpg',
            'token' => 'required|string'
        ])->errors()->messages();

        if ($validationMessages) {
            return response([
                'success' => false,
                'message' => 'Validation failed.',
                'fails' => $validationMessages], 422);
        }
        $user = User::create($request->all());

        $request->user()->currentAccessToken()->delete();
        return response(['success' => true, 'user_id' => $user->id,
            'message' => 'New user successfully registered'],
            Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     */
    public function show($id)
    {
        $user = User::findOrFail($id);
        $positionName = $user->position->name;
        Arr::except($user, 'position');
        $user['position'] = $positionName;
        return ['success' => true, 'user' => $user];
    }
}
