<?php

namespace Humanity\Api\V1\Controllers;

use Carbon\Carbon;
use Humanity\Api\V1\Transformers\VacationDateTransformer;
use Humanity\Entities\Criterias\FilterByItemCriteria;
use Humanity\Entities\Vacation\Contracts\VacationDateRepository;
use Humanity\Entities\Vacation\Criterias\ApprovedDatesCriteria;
use Humanity\Entities\Vacation\Models\VacationDate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Humanity\Api\V1\Requests\Organisation\VacationCreateRequest;
use Humanity\Api\V1\Transformers\VacationTransformer;
use Humanity\Entities\Vacation\Contracts\VacationRepository;
use Humanity\Entities\Vacation\Models\Vacation;
use Humanity\Entities\User\Models\User;

class VacationController extends Controller
{

    /**
     * @SWG\Get(
     *      path="/api/vacations/{id}",
     *      summary="Get vacation",
     *      tags={"vacations"},
     *      description="Get vacation
    <br> **permission:** _view-vacations_",
     *      produces={"application/json"},
     *      security={
     *         {
     *             "jwt": {"agency-admin"}
     *         }
     *      },
     *      @SWG\Response(
     *          response=200,
     *          description="200 OK",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/PhaseTransformerV1")
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=400,
     *          description="400 Bad Request",
     *      ),
     *      @SWG\Response(
     *          response=500,
     *          description="500 Internal Server Error",
     *      )
     * )
     *
     * Return vacation by id
     * @param $id
     * @param VacationRepository $vacationRepository
     * @return \Dingo\Api\Http\Response
     */
    public function show($id, VacationRepository $vacationRepository)
    {
        return $this->response
            ->item($vacationRepository->find($id), new VacationTransformer())
            ->setStatusCode(Response::HTTP_OK);
    }


    /**
     * @SWG\Get(
     *      path="/api/vacations/total",
     *      summary="Get total vacation dates",
     *      tags={"vacations"},
     *      description="Get vacation
    <br> **permission:** _view-vacations_",
     *      produces={"application/json"},
     *      security={
     *         {
     *             "jwt": {"agency-admin"}
     *         }
     *      },
     *      @SWG\Response(
     *          response=200,
     *          description="200 OK",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/PhaseTransformerV1")
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=400,
     *          description="400 Bad Request",
     *      ),
     *      @SWG\Response(
     *          response=500,
     *          description="500 Internal Server Error",
     *      )
     * )
     *
     * Return vacations left by id
     * @param VacationDateRepository $vacationDateRepository
     * @return \Dingo\Api\Http\Response
     */
    public function total(VacationDateRepository $vacationDateRepository)
    {
        $vacationDateRepository->pushCriteria(new ApprovedDatesCriteria());

        return $this->response
            ->collection($vacationDateRepository->all(), new VacationDateTransformer())
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @SWG\Get(
     *      path="/api/vacations",
     *      summary="Get all vacations",
     *      tags={"vacations"},
     *      description="Return all vacations
    <br> **permission:** _view-vacation_",
     *      produces={"application/json"},
     *      security={
     *         {
     *             "jwt": {"agency-admin"}
     *         }
     *      },
     *      @SWG\Response(
     *          response=200,
     *          description="200 OK",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="data",
     *                  type="array",
     *                  @SWG\Items(ref="#/definitions/PhaseTransformerV1")
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=400,
     *          description="400 Bad Request",
     *      ),
     *      @SWG\Response(
     *          response=500,
     *          description="500 Internal Server Error",
     *      )
     * )
     *
     * Return all vacations
     * @param VacationRepository $vacationRepository
     * @return \Dingo\Api\Http\Response
     */
    public function index(VacationRepository $vacationRepository)
    {
        if(auth()->user()->hasPermissionTo('create-vacation')){
            $vacationRepository->pushCriteria(
                new FilterByItemCriteria(Vacation::USER_ID, auth()->user()->{User::ID})
            );
        }

        return $this->response
            ->collection($vacationRepository->all(), new VacationTransformer())
            ->setStatusCode(Response::HTTP_OK);
    }

    /**
     * @SWG\Post(
     *      path="/api/vacations",
     *      summary="Create vacation",
     *      tags={"vacations"},
     *      description="Create vacation",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="auth",
     *          in="body",
     *          description="User that should be authorization",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/PhaseCreateRequestV1")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="200 OK",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="token",
     *                  type="string"
     *              )
     *          )
     *      ),
     *     @SWG\Response(
     *          response=210,
     *          description="210 Two way authorization requested",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="hash",
     *                  type="string"
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="401 Unauthorized",
     *          @SWG\Schema(ref="#/definitions/UnauthorizedErrorResponseV1")
     *      ),
     *      @SWG\Response(
     *          response=422,
     *          description="422 Unprocessable Entity",
     *          @SWG\Schema(ref="#/definitions/ValidationErrorResponseV1")
     *      ),
     *      @SWG\Response(
     *          response=500,
     *          description="500 Server Error",
     *      )
     * )
     *
     * Get a JWT via given credentials.
     *
     * @param VacationCreateRequest $vacationCreateRequest
     * @param VacationRepository $vacationRepository
     * @return \Dingo\Api\Http\Response
     */
    public function create(VacationCreateRequest $vacationCreateRequest, VacationRepository $vacationRepository)
    {
        $vacation = $vacationRepository->create(
            $vacationCreateRequest->only(Vacation::NAME) +
            [Vacation::USER_ID => auth()->user()->{User::ID}]
        );

        foreach ($vacationCreateRequest->dates as $date) {
            $vacationDate = Carbon::parse($date);

            if(!$vacationDate->isWeekday()) {
                $vacation->dates()->create([
                    VacationDate::VACATION_ID => $vacation->{Vacation::ID},
                    VacationDate::DATE        => Carbon::parse($date)
                ]);
            }
        }

        return $this->response
            ->item($vacation, new VacationTransformer())
            ->setStatusCode(Response::HTTP_CREATED);
    }


    /**
     * @SWG\Put(
     *      path="/api/vacations",
     *      summary="Update vacation",
     *      tags={"vacations"},
     *      description="Update vacation",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="auth",
     *          in="body",
     *          description="User that should be authorization",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/UserLoginRequestV1")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="200 OK",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="token",
     *                  type="string"
     *              )
     *          )
     *      ),
     *     @SWG\Response(
     *          response=210,
     *          description="210 Two way authorization requested",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="hash",
     *                  type="string"
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="401 Unauthorized",
     *          @SWG\Schema(ref="#/definitions/UnauthorizedErrorResponseV1")
     *      ),
     *      @SWG\Response(
     *          response=422,
     *          description="422 Unprocessable Entity",
     *          @SWG\Schema(ref="#/definitions/ValidationErrorResponseV1")
     *      ),
     *      @SWG\Response(
     *          response=500,
     *          description="500 Server Error",
     *      )
     * )
     *
     * Update vacation
     *
     * @param Request $request
     * @param $id
     * @param VacationRepository $vacationRepository
     * @return \Dingo\Api\Http\Response
     */
    public function update(Request $request, $id, VacationRepository $vacationRepository)
    {
        $vacation = $vacationRepository->update($request->all(), $id);

        return $this->response
            ->item($vacation, new VacationTransformer())
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    /**
     * @SWG\Put(
     *      path="/api/vacations/approve/{id}",
     *      summary="Approve vacation",
     *      tags={"vacations"},
     *      description="Approve vacation",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="auth",
     *          in="body",
     *          description="User that should be authorization",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/UserLoginRequestV1")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="200 OK",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="token",
     *                  type="string"
     *              )
     *          )
     *      ),
     *     @SWG\Response(
     *          response=210,
     *          description="210 Two way authorization requested",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="hash",
     *                  type="string"
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="401 Unauthorized",
     *          @SWG\Schema(ref="#/definitions/UnauthorizedErrorResponseV1")
     *      ),
     *      @SWG\Response(
     *          response=422,
     *          description="422 Unprocessable Entity",
     *          @SWG\Schema(ref="#/definitions/ValidationErrorResponseV1")
     *      ),
     *      @SWG\Response(
     *          response=500,
     *          description="500 Server Error",
     *      )
     * )
     *
     * Update vacation
     *
     * @param Request $request
     * @param $id
     * @param VacationRepository $vacationRepository
     * @return \Dingo\Api\Http\Response
     */
    public function approve(Request $request, $id, VacationRepository $vacationRepository)
    {
        $vacation = $vacationRepository->update([
            Vacation::APPROVED => true
        ], $id);

        return $this->response
            ->item($vacation, new VacationTransformer())
            ->setStatusCode(Response::HTTP_OK);
    }


    /**
     * @SWG\Put(
     *      path="/api/vacations/disapprove/{id}",
     *      summary="Disapprove vacation",
     *      tags={"vacations"},
     *      description="Disapprove vacation",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="auth",
     *          in="body",
     *          description="User that should be authorization",
     *          required=false,
     *          @SWG\Schema(ref="#/definitions/UserLoginRequestV1")
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="200 OK",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="token",
     *                  type="string"
     *              )
     *          )
     *      ),
     *     @SWG\Response(
     *          response=210,
     *          description="210 Two way authorization requested",
     *          @SWG\Schema(
     *              type="object",
     *              @SWG\Property(
     *                  property="hash",
     *                  type="string"
     *              )
     *          )
     *      ),
     *      @SWG\Response(
     *          response=401,
     *          description="401 Unauthorized",
     *          @SWG\Schema(ref="#/definitions/UnauthorizedErrorResponseV1")
     *      ),
     *      @SWG\Response(
     *          response=422,
     *          description="422 Unprocessable Entity",
     *          @SWG\Schema(ref="#/definitions/ValidationErrorResponseV1")
     *      ),
     *      @SWG\Response(
     *          response=500,
     *          description="500 Server Error",
     *      )
     * )
     *
     * Update vacation
     *
     * @param Request $request
     * @param $id
     * @param VacationRepository $vacationRepository
     * @return \Dingo\Api\Http\Response
     */
    public function disapprove(Request $request, $id, VacationRepository $vacationRepository)
    {
        $vacation = $vacationRepository->update([
            Vacation::APPROVED => false
        ], $id);

        return $this->response
            ->item($vacation, new VacationTransformer())
            ->setStatusCode(Response::HTTP_OK);
    }
}
