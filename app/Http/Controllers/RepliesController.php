<?php namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Phphub\Core\CreatorListener;
use App\Http\Requests\StoreReplyRequest;
use App\Models\Reply;
use Flash;

class RepliesController extends Controller implements CreatorListener
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(StoreReplyRequest $request)
    {
        return app('Phphub\Creators\ReplyCreator')->create($this, $request->except('_token'));
    }

    public function vote($id)
    {
        $reply = Reply::find($id);
        $type = app('Phphub\Vote\Voter')->replyUpVote($reply);

        return response([
            'status'  => 200,
            'message' => lang('Operation succeeded.'),
            'type'    => $type['action_type'],
        ]);
    }

    public function destroy($id)
    {
        $reply = Reply::findOrFail($id);
        $this->authorize('delete', $reply);
        $reply->delete();

        $reply->topic->decrement('reply_count', 1);

        $reply->topic->generateLastReplyUserInfo();

        return response(['status' => 200, 'message' => lang('Operation succeeded.')]);
    }

    /**
     * ----------------------------------------
     * CreatorListener Delegate
     * ----------------------------------------
     */

    public function creatorFailed($errors)
    {
        return response([
                    'status'  => 500,
                    'message' => lang('Operation failed.'),
                ]);
    }

    public function creatorSucceed($reply)
    {
        $reply->user->image_url = $reply->user->present()->gravatar;

        return response([
                    'status'        => 200,
                    'message'       => lang('Operation succeeded.'),
                    'reply'         => $reply,
                    'manage_topics' => $reply->user->may('manage_topics') ? 'yes' : 'no',
                ]);
    }
}
