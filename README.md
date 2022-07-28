Examples:

namespace App\Http\Controllers\Users;

use VeseluyRodjer\JsonWebToken\Services\JsonWebTokenService;

class CustomerController extends Controller
{
    public function __construct(
        private JsonWebTokenService $jsonWebTokenService
    ) {}

    public function usingPackage(): JsonResponse
    {
        $token = $this->jsonWebTokenService->createToken([
            'payload' => [
                'user_email' => request()->email,
                'role_name' => request()->role_name
            ],
            'secret' => config('jwt.secret'),
        ]);

        $dataFromToken = $this->jsonWebTokenService->getDataFromToken($request->token);
    }
}

namespace App\Http\Requests\User;

use VeseluyRodjer\JsonWebToken\Services\JsonWebTokenService;

class AdminRequest extends FormRequest
{
    public function __construct(
        private JsonWebTokenService $jsonWebTokenService
    ) {}

    public function rules()
    {
        return [
            'token' => [
                function ($attribute, $value, $fail) {
                    if (! $this->jsonWebTokenService->checkToken($value, config('jwt.secret'))) {
                        $fail('The '.$attribute.' is invalid.');
                    }
                },
            ],
        ];
    }
}
