<?php

namespace App\Http\Controllers;

use App\Models\Tweet;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TweetController extends Controller
{
    /**
     * 1. Hiển thị danh sách Tweet ra trang Welcome
     */
    public function index()
    {
        return Inertia::render('Welcome', [
            // Lấy danh sách tweet, bài mới nhất xếp lên đầu
            'tweets' => Tweet::orderBy('id', 'desc')->get()
        ]);
    }

    /**
     * 2. Lưu bài viết mới (kèm upload ảnh hoặc video nếu có)
     */
    public function store(Request $request)
    {
        $file = null;
        $extension = null;
        $fileName = null;
        $path = '';

        // Kiểm tra nếu người dùng có đính kèm file
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $request->validate([ 'file' => 'required|mimes:jpg,jpeg,png,mp4' ]);
            $extension = $file->getClientOriginalExtension();
            $fileName = time() . '.' . $extension;

            // Nếu đuôi mp4 thì lưu vào /videos/, còn lại lưu vào /pics/
            $extension === 'mp4' ? $path = '/videos/' : $path = '/pics/';
        }

        $tweet = new Tweet;

        // Tác giả mặc định
        $tweet->name = 'John Weeks Dev';
        $tweet->handle = '@johnweeksdev';
        $tweet->image = 'https://yt3.ggpht.com/e9o-24_frmNSSVvjS47rT8qCHgsHNiedqgXbzmrmpsj6H1ketcufR1B9vLXTZRa30krRksPj=s88-c-k-c0x00ffffff-no-rj-mo';
        $tweet->tweet = $request->input('tweet');

        // Nếu có upload file
        if ($fileName) {
            $tweet->file = $path . $fileName;
            $tweet->is_video = ($extension === 'mp4');
            $file->move(public_path() . $path, $fileName);
        }

        // Tạo ngẫu nhiên số lượng tương tác
        $tweet->comments = rand(5, 500);
        $tweet->retweets = rand(5, 500);
        $tweet->likes = rand(5, 500);
        $tweet->analytics = rand(5, 500);

        $tweet->save();
    }

    /**
     * 3. Xóa Tweet và xóa file media tương ứng
     */
    public function destroy($id)
    {
        $tweet = Tweet::find($id);

        // Nếu bài viết có file và file đó tồn tại trên ổ cứng -> xóa file
        if (!is_null($tweet->file) && file_exists(public_path() . $tweet->file)) {
            unlink(public_path() . $tweet->file);
        }

        // Xóa bản ghi trong database
        $tweet->delete();

        return redirect()->route('tweets.index');
    }
}