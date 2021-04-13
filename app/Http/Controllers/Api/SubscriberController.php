<?php

namespace App\Http\Controllers\Api;

use App\Http\Transformers\SubscriberTransformer;
use App\Repositories\Subscribers\SubscriberRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SubscriberController extends Controller
{
    private SubscriberRepositoryInterface $subscriberRepo;

    public function __construct(SubscriberRepositoryInterface $subscriber)
    {
        $this->subscriberRepo = $subscriber;
        $this->setTransformer(new SubscriberTransformer());
    }

    private function validateStoreRule(): array
    {
        return [
            'name'       => 'required|max:50',
            'email'      => 'required|email|unique:subscribers,email',
            'contact_id' => 'required|exists:contacts,id',
            'phone'      => 'nullable|max:11',
        ];
    }

    private function validateStoreMessage(): array
    {
        return [
            'name.required'       => 'Tên là bắt buộc',
            'name.max'            => 'Tên không được quá 50 ký tự',
            'email.required'      => 'Email là bắt buộc',
            'email.email'         => 'Email không đúng định dạng',
            'email.unique'        => 'Email đã tồn tại trên hệ thống',
            'contact_id.required' => 'Contact là bắt buộc',
            'contact_id.exists'   => 'Contact không tồn tại trong hệ thống',
            'phone.max'           => 'Phone không được quá 11 ký tự',
        ];
    }

    public function store(Request $request)
    {
        try {
            $this->validate($request, $this->validateStoreRule(), $this->validateStoreMessage());

            $params = $request->all();
            $data   = $this->subscriberRepo->store($params);

            return $this->successResponse($data);
        } catch (ValidationException $e) {
            return $this->errorResponse([
                'errors'    => $e->validator->errors(),
                'exception' => $e->getMessage()
            ]);
        } catch (\Throwable $t) {
            throw $t;
        }
    }

}
