<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Helpers\APIHelper;
use App\Models\TodoNotes;
use App\Models\User;
use Illuminate\Http\Request;
use Validator;

/**
 * Summary of TodoNotesController
 */
class TodoNotesController extends Controller
{
    protected $successStatus;
    protected $successMsg;
    protected $systemError;
    protected $systemErrorCode;
    protected $notFoundError;
    protected $notFoundErrorCode;
    protected $noUserFound;
    protected $badRequestCode;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->successStatus     = config('constants.SUCCESS_CODE');
        $this->successMsg        = config('constants.SUCCESS_MSG');
        $this->systemError       = config('constants.SYSTEM_ERROR');
        $this->systemErrorCode   = config('constants.SYSTEM_ERROR_CODE');
        $this->notFoundError     = config('constants.NOT_DATA_FOUND');
        $this->notFoundErrorCode = config('constants.NOT_DATA_FOUND_CODE');
        $this->noUserFound       = config('constants.NOT_USER_FOUND'); 
        $this->badRequestCode    = config('constants.BAD_REQUEST_CODE');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $todoNotes = TodoNotes::where('archived', false)->get();
            return response()->json(APIHelper::createAPIResponse($todoNotes, $this->successStatus, $this->successMsg), $this->successStatus);
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(APIHelper::errorAPIResponse($this->systemError, $this->systemErrorCode), $this->systemErrorCode);
        }
    }

    /**
     * Archived a TodoNotes.
     *
     * @return \Illuminate\Http\JsonResponse   The JSON response containing the archived TodoNotes.
     */
    public function archived()
    {
        try {
            $todoNotes = TodoNotes::where('archived', true)->get();
            return response()->json(APIHelper::createAPIResponse($todoNotes, $this->successStatus, $this->successMsg), $this->successStatus);
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(APIHelper::errorAPIResponse($this->systemError, $this->systemErrorCode), $this->systemErrorCode);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        try {
            // Validation
            $validatedData = Validator::make($request->all(), [
                'user_id' => 'required|integer',
                'title' => 'required|string',
                'description' => 'nullable|string',
            ]);
    
            if ($validatedData->fails()) {
                return response()->json(APIHelper::errorAPIResponse($validatedData->errors(), $this->badRequestCode), $this->badRequestCode);
            }
            $user = User::where(['id' => $request->input('user_id')])->first();
            if($user) {
                $todoNotes = TodoNotes::create($validatedData->validated());
                return response()->json(APIHelper::createAPIResponse($todoNotes, $this->successStatus, $this->successMsg), $this->successStatus);
            } else {
                return response()->json(APIHelper::errorAPIResponse($this->noUserFound, $this->notFoundErrorCode), $this->notFoundErrorCode);
            }
            
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(APIHelper::errorAPIResponse($e->getMessage(), $this->systemErrorCode), $this->systemErrorCode);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $todoNotes = TodoNotes::find($id);
            if($todoNotes) {
                return response()->json(APIHelper::createAPIResponse($todoNotes, $this->successStatus, $this->successMsg), $this->successStatus);
            } else {
                return response()->json(APIHelper::errorAPIResponse($this->notFoundError, $this->notFoundErrorCode), $this->notFoundErrorCode);
            }
            
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(APIHelper::errorAPIResponse($this->systemError, $this->systemErrorCode), $this->systemErrorCode);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        try {
            $todoNote = TodoNotes::find($id);
            
            if ($todoNote) {
                if($request->has('title') && $request->input('title') == null) {
                    return response()->json(APIHelper::errorAPIResponse('title is required.', $this->badRequestCode), $this->badRequestCode);
                }
                $validatedData =  $request->all();
                $todoNote->update($validatedData);
                return response()->json(APIHelper::createAPIResponse($todoNote, $this->successStatus, $this->successMsg), $this->successStatus);
            } else {
                return response()->json(APIHelper::errorAPIResponse($this->notFoundError, $this->notFoundErrorCode), $this->notFoundErrorCode);
            }
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(APIHelper::errorAPIResponse($this->systemError, $this->systemErrorCode), $this->systemErrorCode);
        }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $todoNotes = TodoNotes::find($id);
        if($todoNotes) {
            $todoNotes->delete();
            return response()->json(APIHelper::createAPIResponse('deletion successfull.', $this->successStatus, $this->successMsg), $this->successStatus);
        } else {
            return response()->json(APIHelper::errorAPIResponse($this->notFoundError, $this->notFoundErrorCode), $this->notFoundErrorCode);
        }
    }

    /**
     * Archive a TodoNotes.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse   The JSON response containing the archived TodoNotes.
     */

    public function archive($id)
    {
        try {
            $todoNote = TodoNotes::find($id);
            if ($todoNote) {
                $archive = request()->query('archived', 0); // Get the 'archive' query parameter value, defaulting to false
                if($archive === '1' || $archive === '0') {
                    $archive = (int) $archive;
                } else {
                    return response()->json(APIHelper::errorAPIResponse('invalid request params.', $this->badRequestCode), $this->badRequestCode);
                }
                
                $todoNote->update(['archived' => $archive]);
                return response()->json(APIHelper::createAPIResponse($todoNote, $this->successStatus, $this->successMsg), $this->successStatus);
            } else {
                return response()->json(APIHelper::errorAPIResponse($this->notFoundError, $this->notFoundErrorCode), $this->notFoundErrorCode);
            }
        } catch (\Exception $e) {
            // Handle the exception
            return response()->json(APIHelper::errorAPIResponse($this->systemError, $this->systemErrorCode), $this->systemErrorCode);
        }
    }
}
