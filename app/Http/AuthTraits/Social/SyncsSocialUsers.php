<?php

namespace App\Http\AuthTraits\Social;

use App\Exceptions\AlreadySyncedException;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;
use App\SocialProvider;
use App\Exceptions\CredentialsDoNotMatchException;

trait SyncsSocialUsers
{
    /**
     * @param $facebookUser
     * @return mixed
     */

    private function accountSynced($socialUser)
    {
        if ($this->authUserEmailMatches($socialUser)){

            return $this->verifyUserIds($socialUser);

        }

        return false;

    }

    private function checkIfAccountSyncedOrSync($socialUser)
    {
        //if you are logged in and accountSynced is true, you are already synced

        if ($this->accountSynced($socialUser)){

            // update user account with latest avatar
            
            $this->updateUserWithAvatarFromSocialData($socialUser);

            throw new AlreadySyncedException;

        } else {

            // check for email match

            if ( ! $this->authUserEmailMatches($socialUser)) {

                throw new CredentialsDoNotMatchException;

            }

            // if emails match, then sync accounts

            $this->syncUserAccountWithSocialData($socialUser);
            
            
            // update user's avatar
            
            $this->updateUserWithAvatarFromSocialData($socialUser);

            alert()->success('Confirmed!', 'You are now synced...');

            return $this->redirectUser();

        }
    }

    private function syncUserAccountWithSocialData($socialUser)
    {
        // one last check to see if the social id already exists

        if ($this->socialIdAlreadyExists($socialUser)){

            throw new CredentialsDoNotMatchException;

        }
        // lookup user id and update create provider record

        SocialProvider::create([
            'user_id' => Auth::user()->id,
            'source'  => $this->provider,
            'source_id'  => $socialUser->id,
            'avatar'  => $socialUser->avatar
        ]);
        
    }
    
    private function updateUserWithAvatarFromSocialData($socialUser)
    {
        if(! empty($socialUser->avatar)) {
            
            // save avatar to file so it can be easily used
            
            $avatar = file_get_contents($socialUser->avatar);
            
            // create a file name based on hash of email
            
            $filename = hash('adler32', Auth::user()->email);
            
            // create path for avatar file

            $file = dirname(__file__).'/../../../../public/imgs/avatars/'.$filename.'.jpg';
            
            // save avatar to a file
            
            file_put_contents($file, $avatar);
            
            // create url for avatar
            
            $url = '/imgs/avatars/'.$filename.'.jpg';
            
            // update avatar url
            
            Auth::user()->avatar = $url;
            
            // save user data
            
            Auth::user()->save();
            
        }
    }
}
