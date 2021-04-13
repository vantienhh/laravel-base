<?php

namespace App\Http\Controllers\Api;

use App\Http\Transformers\ContactTransformer;
use App\Http\Transformers\SubscriberTransformer;
use App\Repositories\Contacts\ContactRepositoryInterface;
use App\Repositories\Subscribers\SubscriberRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;
use Throwable;

class ContactController extends Controller
{
    private ContactRepositoryInterface    $contactRepo;
    private SubscriberRepositoryInterface $subscriberRepo;

    public function __construct(ContactRepositoryInterface $contact, SubscriberRepositoryInterface $subscriber)
    {
        $this->contactRepo    = $contact;
        $this->subscriberRepo = $subscriber;
    }

    public function index(Request $request)
    {
        $limit = $request->get('limit', 20);
        $params = $request->query() ?: [];

        $data  = $this->contactRepo->getByQuery($params, $limit);
        $this->setTransformer(new ContactTransformer());

        return $this->successResponse($data);
    }

    public function listSubscriber(Request $request, int $contactId)
    {
        try {
            $this->contactRepo->getById($contactId);

            $limit  = $request->get('limit', 20);
            $params = $request->query() ?: [];
            $params = Arr::add($params, 'contact_id', $contactId);

            $data = $this->subscriberRepo->getByQuery($params, $limit);
            $this->setTransformer(new SubscriberTransformer());

            return $this->successResponse($data);
        } catch (ModelNotFoundException $e) {
            return $this->notFoundResponse();
        } catch (Throwable $t) {
            throw $t;
        }
    }

}
