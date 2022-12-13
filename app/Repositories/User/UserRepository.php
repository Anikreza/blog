<?php


namespace App\Repositories\User;


use App\Enums\FileDirectory;
use App\Models\User;
use App\Services\FileUpload;
use DB;
use Illuminate\Http\Request;
use Throwable;

class UserRepository implements UserInterface
{
    /**
     * @param $request
     * @return array
     */

    private function getProfileDataFromRequest($request): array
    {
        return $request([
            'gender',
            'first_name',
            'last_name',
            'address',
        ]);
    }

    /**
     * @param $user
     * @param $request
     * @return array|Throwable
     * @throws Throwable
     */
    public function updateProfile($user, Request $request): ?Throwable
    {
        try {
            DB::beginTransaction();

            $profileData = $this->getProfileDataFromRequest($request);

            if ($request->hasFile('image')) {
                $files = (new FileUpload($request->file('image')))
                    ->directory(FileDirectory::AVATAR . $user->id)
                    ->setDimension(null, 250)
                    ->setFileName($request->file('image')->getClientOriginalName())
                    ->upload();

                $profileData['avatar'] = $files['main_file_name'];
            }

            $user = User::where('id', $user->id)->update($profileData);
            DB::commit();

            return $user;
        } catch (Throwable $e) {
            DB::rollBack();

            return $e;
        }
    }

    public function updatePassword($userId)
    {
        // TODO: Implement updatePassword() method.
    }

    public function emailUpdate($userId)
    {
        // TODO: Implement emailUpdate() method.
    }

    public function emailVerification($email)
    {
        // TODO: Implement emailVerification() method.
    }

    public function tokenVerification($email)
    {
        // TODO: Implement tokenVerification() method.
    }


}
