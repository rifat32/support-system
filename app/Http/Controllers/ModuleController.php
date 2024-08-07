<?php

namespace App\Http\Controllers;

use App\Http\Requests\EnableBusinessModuleRequest;
use App\Http\Requests\EnableServicePlanModuleRequest;
use App\Http\Requests\GetIdRequest;
use App\Http\Utils\ErrorUtil;
use App\Http\Utils\UserActivityUtil;
use App\Models\Business;
use App\Models\BusinessModule;
use App\Models\Module;
use App\Models\ServicePlanModule;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    use ErrorUtil, UserActivityUtil;
   /**
     *
     * @OA\Put(
     *      path="/v1.0/modules/toggle-active",
     *      operationId="toggleActiveModule",
     *      tags={"modules"},
     *       security={
     *           {"bearerAuth": {}}
     *       },
     *      summary="This method is to toggle module active",
     *      description="This method is to toggle module active",
     *
     *  @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *           @OA\Property(property="id", type="string", format="number",example="1"),
     *
     *         ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       @OA\JsonContent(),
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     * @OA\JsonContent(),
     *      ),
     *        @OA\Response(
     *          response=422,
     *          description="Unprocesseble Content",
     *    @OA\JsonContent(),
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *   @OA\JsonContent()
     * ),
     *  * @OA\Response(
     *      response=400,
     *      description="Bad Request",
     *   *@OA\JsonContent()
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found",
     *   *@OA\JsonContent()
     *   )
     *      )
     *     )
     */

     public function toggleActiveModule(GetIdRequest $request)
     {

         try {
             $this->storeActivity($request, "DUMMY activity","DUMMY description");

             if (!$request->user()->hasPermissionTo('module_update')) {
                 return response()->json([
                     "message" => "You can not perform this action"
                 ], 401);
             }
             $request_data = $request->validated();


            $module = Module::where([
                "id" => $request_data["id"]
            ])
                ->first();
            if (!$module) {

                return response()->json([
                    "message" => "no module found"
                ], 404);
            }


             $module->update([
                 'is_enabled' => !$module->is_enabled
             ]);

             return response()->json(['message' => 'Module status updated successfully'], 200);
         } catch (Exception $e) {
             error_log($e->getMessage());
             return $this->sendError($e, 500, $request);
         }
     }

      /**
     *
     * @OA\Put(
     *      path="/v1.0/business-modules/enable",
     *      operationId="enableBusinessModule",
     *      tags={"modules"},
     *       security={
     *           {"bearerAuth": {}}
     *       },
     *      summary="This method is to toggle module active",
     *      description="This method is to toggle module active",
     *
     *  @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *
     *
     *
     *           @OA\Property(property="business_id", type="string", format="number",example="1"),
     *           @OA\Property(property="active_module_ids", type="string", format="array",example="{1,2,3}"),
     *
     *
     *
     *         ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       @OA\JsonContent(),
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     * @OA\JsonContent(),
     *      ),
     *        @OA\Response(
     *          response=422,
     *          description="Unprocesseble Content",
     *    @OA\JsonContent(),
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *   @OA\JsonContent()
     * ),
     *  * @OA\Response(
     *      response=400,
     *      description="Bad Request",
     *   *@OA\JsonContent()
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found",
     *   *@OA\JsonContent()
     *   )
     *      )
     *     )
     */

     public function enableBusinessModule(EnableBusinessModuleRequest $request)
     {

         try {
             $this->storeActivity($request, "DUMMY activity","DUMMY description");
             if (!$request->user()->hasPermissionTo('module_update')) {
                 return response()->json([
                     "message" => "You can not perform this action"
                 ], 401);
             }
             $request_data = $request->validated();



             BusinessModule::where([
                "business_id" => $request_data["business_id"]
             ])
             ->delete();

        foreach($request_data["active_module_ids"] as $active_module_id){
           BusinessModule::create([
            "is_enabled" => 1,
            "business_id" => $request_data["business_id"],
            "module_id" => $active_module_id,
            'created_by' => auth()->user()->id
           ]);
        }



             return response()->json(['message' => 'Module status updated successfully'], 200);



         } catch (Exception $e) {
             error_log($e->getMessage());
             return $this->sendError($e, 500, $request);
         }
     }

    /**
     *
     * @OA\Put(
     *      path="/v1.0/service-plan-modules/enable",
     *      operationId="enableServicePlanModule",
     *      tags={"modules"},
     *       security={
     *           {"bearerAuth": {}}
     *       },
     *      summary="This method is to toggle module active",
     *      description="This method is to toggle module active",
     *
     *  @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *
     *
     *
     *           @OA\Property(property="service_plan_id", type="string", format="number",example="1"),
     *           @OA\Property(property="active_module_ids", type="string", format="array",example="{1,2,3}"),
     *
     *
     *
     *         ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       @OA\JsonContent(),
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     * @OA\JsonContent(),
     *      ),
     *        @OA\Response(
     *          response=422,
     *          description="Unprocesseble Content",
     *    @OA\JsonContent(),
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *   @OA\JsonContent()
     * ),
     *  * @OA\Response(
     *      response=400,
     *      description="Bad Request",
     *   *@OA\JsonContent()
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found",
     *   *@OA\JsonContent()
     *   )
     *      )
     *     )
     */

     public function enableServicePlanModule(EnableServicePlanModuleRequest $request)
     {

         try {
             $this->storeActivity($request, "DUMMY activity","DUMMY description");
             if (!$request->user()->hasPermissionTo('module_update') || !$request->user()->hasPermissionTo('service_plan_update')) {
                 return response()->json([
                     "message" => "You can not perform this action"
                 ], 401);
             }

             $request_data = $request->validated();

             ServicePlanModule::where([
                "service_plan_id" => $request_data["service_plan_id"]
             ])
             ->delete();


        foreach($request_data["active_module_ids"] as $active_module_id){
            ServicePlanModule::create([
            "is_enabled" => 1,
            "service_plan_id" => $request_data["service_plan_id"],
            "module_id" => $active_module_id,
            'created_by' => auth()->user()->id
           ]);
        }



             return response()->json(['message' => 'Module status updated successfully'], 200);



         } catch (Exception $e) {
             error_log($e->getMessage());
             return $this->sendError($e, 500, $request);
         }
     }


 /**
     *
     * @OA\Get(
     *      path="/v1.0/modules",
     *      operationId="getModules",
     *      tags={"modules"},
     *       security={
     *           {"bearerAuth": {}}
     *       },

     *              @OA\Parameter(
     *         name="per_page",
     *         in="query",
     *         description="per_page",
     *         required=true,
     *  example="6"
     *      ),
     *      * *  @OA\Parameter(
     * name="start_date",
     * in="query",
     * description="start_date",
     * required=true,
     * example="2019-06-29"
     * ),
     * *  @OA\Parameter(
     * name="end_date",
     * in="query",
     * description="end_date",
     * required=true,
     * example="2019-06-29"
     * ),
     * *  @OA\Parameter(
     * name="search_key",
     * in="query",
     * description="search_key",
     * required=true,
     * example="search_key"
     * ),
     *    * *  @OA\Parameter(
     * name="business_tier_id",
     * in="query",
     * description="business_tier_id",
     * required=true,
     * example="1"
     * ),
     * *  @OA\Parameter(
     * name="order_by",
     * in="query",
     * description="order_by",
     * required=true,
     * example="ASC"
     * ),

     *      summary="This method is to get modules",
     *      description="This method is to get modules",
     *

     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       @OA\JsonContent(),
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     * @OA\JsonContent(),
     *      ),
     *        @OA\Response(
     *          response=422,
     *          description="Unprocesseble Content",
     *    @OA\JsonContent(),
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *   @OA\JsonContent()
     * ),
     *  * @OA\Response(
     *      response=400,
     *      description="Bad Request",
     *   *@OA\JsonContent()
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found",
     *   *@OA\JsonContent()
     *   )
     *      )
     *     )
     */

     public function getModules(Request $request)
     {
         try {
             $this->storeActivity($request, "DUMMY activity","DUMMY description");
             if (!$request->user()->hasPermissionTo('module_view')) {
                 return response()->json([
                     "message" => "You can not perform this action"
                 ], 401);
             }

             $modules = Module::when(!$request->user()->hasPermissionTo('module_update'), function ($query) use ($request) {
                return $query->where('modules.is_active', 1);
            })
            //  ->when(!empty($request->business_tier_id), function ($query) use ($request) {
            //      return $query->where('modules.business_tier_id', $request->business_tier_id);
            //  })
            //  ->when(empty($request->business_tier_id), function ($query) use ($request) {
            //     return $query->where('modules.business_tier_id', NULL);
            // })
                 ->when(!empty($request->search_key), function ($query) use ($request) {
                     return $query->where(function ($query) use ($request) {
                         $term = $request->search_key;
                         $query->where("modules.name", "like", "%" . $term . "%");
                     });
                 })
                 //    ->when(!empty($request->product_category_id), function ($query) use ($request) {
                 //        return $query->where('product_category_id', $request->product_category_id);
                 //    })
                 ->when(!empty($request->start_date), function ($query) use ($request) {
                     return $query->where('modules.created_at', ">=", $request->start_date);
                 })
                 ->when(!empty($request->end_date), function ($query) use ($request) {
                     return $query->where('modules.created_at', "<=", ($request->end_date . ' 23:59:59'));
                 })
                 ->when(!empty($request->order_by) && in_array(strtoupper($request->order_by), ['ASC', 'DESC']), function ($query) use ($request) {
                     return $query->orderBy("modules.id", $request->order_by);
                 }, function ($query) {
                     return $query->orderBy("modules.id", "DESC");
                 })
                 ->select("id","name")
                 ->when(!empty($request->per_page), function ($query) use ($request) {
                     return $query->paginate($request->per_page);
                 }, function ($query) {
                     return $query->get();
                 });


             return response()->json($modules, 200);
         } catch (Exception $e) {

             return $this->sendError($e, 500, $request);
         }
     }



 /**
     *
     * @OA\Get(
     *      path="/v1.0/business-modules/{business_id}",
     *      operationId="getBusinessModules",
     *      tags={"modules"},
     *       security={
     *           {"bearerAuth": {}}
     *       },

     *              @OA\Parameter(
     *         name="business_id",
     *         in="path",
     *         description="business_id",
     *         required=true,
     *  example="6"
     *      ),


     *      summary="This method is to get modules",
     *      description="This method is to get modules",
     *

     *      @OA\Response(
     *          response=200,
     *          description="Successful operation",
     *       @OA\JsonContent(),
     *       ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     * @OA\JsonContent(),
     *      ),
     *        @OA\Response(
     *          response=422,
     *          description="Unprocesseble Content",
     *    @OA\JsonContent(),
     *      ),
     *      @OA\Response(
     *          response=403,
     *          description="Forbidden",
     *   @OA\JsonContent()
     * ),
     *  * @OA\Response(
     *      response=400,
     *      description="Bad Request",
     *   *@OA\JsonContent()
     *   ),
     * @OA\Response(
     *      response=404,
     *      description="not found",
     *   *@OA\JsonContent()
     *   )
     *      )
     *     )
     */

     public function getBusinessModules($business_id,Request $request)
     {
         try {
             $this->storeActivity($request, "DUMMY activity","DUMMY description");
             if (!$request->user()->hasPermissionTo('module_view')) {
                 return response()->json([
                     "message" => "You can not perform this action"
                 ], 401);
             }

             $businessQuery  = Business::where(["id" => $business_id]);


             if (!auth()->user()->hasRole('superadmin')) {
                 $businessQuery = $businessQuery->where(function ($query) {
                     return   $query
                        ->when(!auth()->user()->hasPermissionTo("handle_self_registered_businesses"),function($query) {
                         $query->where('id', auth()->user()->business_id)
                         ->orWhere('created_by', auth()->user()->id)
                         ->orWhere('owner_id', auth()->user()->id);
                        },
                        function($query) {
                         $query->where('is_self_registered_businesses', 1)
                         ->orWhere('created_by', auth()->user()->id);
                        }

                     );

                 });
             }

             $business =  $businessQuery->first();


             if (empty($business)) {

                 return response()->json([
                     "message" => "no business found"
                 ], 404);
             }


             $modules = Module::where('modules.is_enabled', 1)
                 ->orderBy("modules.name", "ASC")

                 ->select("id","name")
                ->get()

                ->map(function($item) use($business) {
                    $item->is_enabled = 0;

                $businessModule =    BusinessModule::where([
                    "business_id" => $business->id,
                    "module_id" => $item->id
                ])
                ->first();

                if(!empty($businessModule)) {
                    if($businessModule->is_enabled) {
                        $item->is_enabled = 1;
                    }

                }



                    return $item;
                });



             return response()->json($modules, 200);
         } catch (Exception $e) {

             return $this->sendError($e, 500, $request);
         }
     }






}
