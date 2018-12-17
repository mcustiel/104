# 104

Simple implementation of CommandBus and QueryBus that just works.

The CommandBus and QueryBus usage is very similar. The main difference is that the commands don't return a value and the queries return an optional one.

## Example

Use in symfony:

```php
<?php
// UserController.php
class UsersController extends Controller
{
    /** @var QueryBus */
    private $queryBus;
    
    public function __construct(QueryBus $queryBus)
    {
        $this->queryBus = $queryBus;
    }
    
    /**
     * @Route("/user/{id}", name="user_data", methods={"GET"})
     */
    public function getLoggedUserData($id): Response
    {
        try {
            $userId = new UserId($id);
            $result = $this->queryBus->dispatch(new GetUserDataQuery($userId));

            if ($result->isPresent()) {
                $user = $result->getResult();
                $userSettings = $user->getSettings();

                return new JsonResponse($user);
            }

            return new JsonREsponse(
                ['message' => 'error.userNotFound'],
                JsonResponse::HTTP_NOT_FOUND
            );
        } catch (\Exception $e) {
            return new JsonResponse(
                ['message' => 'error.unexpected ' . $e->__toString()],
                JsonResponse::HTTP_INTERNAL_SERVER_ERROR
            );
        }
    }
```

```php
<?php
// GetUserDataQuery.php

class GetUserDataQuery implements Query
{
    /** @var UserId */
    private $userId;

    public function __construct(UserId $userId)
    {
        $this->userId = $userId;
    }

    public function getUserId(): UserId
    {
        return $this->userId;
    }

    public function getQueryHandler(): HandlerIdentifier
    {
        return new HandlerIdentifier(GetUserDataQueryHandler::class);
    }
}
```

```php
<?php
// GetUserDataQueryHandler.php
class GetUserDataQueryHandler implements QueryHandler
{    
    /** @var UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function handle(Query $query): OptionalResult
    {
        // Do all the magic needed to get the user from repository here
        return new GetUserDataQueryOptionalResult($user);
    }
}
```

```php
<?php
// GetUserDataQueryOptionalResult.php
class GetUserDataQueryOptionalResult extends OptionalResult
{
    public function __construct(?User $result = null)
    {
        parent::__construct($result);
    }

    public function getResult(): User
    {
        return parent::getResult();
    }
}
```
