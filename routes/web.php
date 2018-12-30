<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

use App\User;
use App\Post;
use App\Category;
use App\Role;
use App\Portfolio;
use App\Tag;

Route::get('/create_user', function () {
    $user = User::create([
        'name' => 'Ivan Finiel',
        'email' => 'ivan@gmail.com',
        'password' => bcrypt('password')
    ]);

    return $user;
});

use App\Profile;

Route::get('/create_profile', function () {
    // $profile = Profile::create([
    //     'user_id' => '1',
    //     'phone' => '081270370298',
    //     'address' => 'Padang'
    // ]);

    $user = User::find(1);

    $user->profile()->create([
        'phone' => '12345678',
        'address' => 'alamat baru'
    ]);

    return $user;
});

Route::get('/create_user_profile', function () {
    $user = User::find(2);

    $profile = new Profile([
        'phone' => '0812345',
        'address' => 'Kapalo koto'
    ]);

    $user->profile()->save($profile);
    return $user;
    });

    Route::get('/read_user', function () {
        $user= User::find(1);

        // return $user;

        // return $user->profile->address;

        $data = [
            'name' => $user->name,
            'phone' => $user->profile->phone,
            'address' => $user->profile->address
        ];

        return $data;
        
    });

    Route::get('/read_profile', function () {
        $profile = Profile::where('phone','081270370298')->first(); 

    //    return $profile->user->name; 
    $data = [
        'name' => $profile->user->name,
        'email' => $profile->user->email,
        'phone' => $profile->user->phone,
        'address' => $profile->user->address
    ];

    return $data;
    });

    Route::get('/update_profile', function () {
        $user = User::find(2);

        $data = [
            
            'phone' => '12345',
            'address' =>'peranap'
        ];

        $user->profile()->update($data);
            


        // $user->profile()->update([
        //     'phone' => '081270326543',
        //     'address' => 'Sawahlunto'
        // ]);

        return $user;
        
    });

    Route::get('/delete_profile', function () {
        $user = User::find(1);
        $user->profile()->delete();

        return $user;
        
    });

    Route::get('/create_post', function () {
        // $user = User::create([
        //     'name' => 'gitaa',
        //     'email' => 'gita@ymail.com',
        //     'password' => bcrypt('password')
        // ]);

        $user = User::findOrFail(1);

        $user->posts()->create([
       
            'title' => 'Title data post Baru Milik Admin 1',
            'body' => 'Hello World!, Isi body Baru Milik Admin 1'
        ]);

                return 'Success';
        
    });


    Route::get('/read_posts', function () {
        $user = User::find(1);

        // dd($user->posts()->get());

        $posts = $user->posts()->get();

        foreach($posts as $post) {
            $data[] = [
                'name' => $post->user->name,
                'post_id' => $post->id,
                'title' => $post->title,
                'body' => $post->body

            ];
        }

        // $data = [
        //     'name' => $post->user->name,
        //     'title' => $post->title,
        //     'body' => $post->body
        // ];

        return $data;
        
    });

    Route::get('/update_post', function () {
        $user = User::findOrFail(1);

        $user->posts()->update([
            'title' => 'Ini isian title post update',
            'body' => 'ini isian body post yang sudah di update'
        ]);

        Return 'Success';
        
    });

    Route::get('/delete_post', function () {
        $user = User::find(1);

        $user->posts()->whereId(4)->delete();

        return 'Success';
        
    });


    Route::get('/create_categories', function () {
        // $post = Post::findOrFail(1);

        // $post->categories()->create([
        //     'slug' => str_slug('PHP', '-'),
        //     'category' => 'PHP'
        // ]);

        // return 'Success';

        $user = User::create([
            'name' => 'agit',
            'email' => 'agit@gmail.com',
            'password' => bcrypt('password')
        ]);

        $user->posts()->create([
            'title' => 'New Title',
            'body' => 'New Body Content'
        ])->categories()->create([
            'slug' => str_slug('New Category', '-'),
            'category' => 'New Category'
        ]);

        return 'Success';
        
    });

    Route::get('/read_category', function () {
        $post = Post::find(2);

        // $post->categories();

        // dd($post->categories()); 

        $categories = $post->categories;
        foreach ( $categories as $category) {
            echo $category->slug . '</br>';
        }

        // $category = Category::find(2);

        // $posts = $category->posts;

        // foreach ($posts as $post) {
        //     echo $post->title . '</br>';
        // }
    });

    Route::get('/attach', function () {
        $post = Post::find(3);
        $post->categories()->attach([1,2,3]);

        return 'Success';
        
    });

    Route::get('/detach', function () {
        $post = Post::find(3);
        $post->categories()->detach();

        return 'Success';
        
    });

    Route::get('/sync', function () {
        $post = Post::find(3);
        $post->categories()->sync([1,3]);

        return 'Success';
        
    });

    Route::get('/role/posts', function () {
        $role = Role::find(2);
        return $role->posts;
        
    });


    Route::get('/comment/create', function () {
        // $post = Post::find(1);
        // $post->comments()->create([
        //     'user_id' => 2, 'content'  => 'Balasan dari user ID 1'
        // ]);

        $portfolio = Portfolio::find(1);
        $portfolio->comments()->create([
            'user_id' => 2, 'content'  => 'Balasan dari Portfolio user ID 1'
        ]);
        
        return 'Success';
    });

    Route::get('/comment/read', function () {
        $portfolio = Portfolio::findOrFail(1);
        $comments = $portfolio->comments;
        foreach ($comments as $comment) {
            echo $comment->user->name . ' - ' . $comment->content . ' (' . $comment->commentable->title . ') <br>';
        }

    });


        Route::get('/comment/update', function () {
            // $post = Post::find(1);

            // $comment = $post->comments()->where('id', 1)->first();
            // $comment->update([
            //     'content' => 'Komentarnya telah disunting'
            // ]);

            $portfolio = Portfolio::find(1);

            $comment = $portfolio->comments()->where('id', 3)->first();
            $comment->update([
                'content' => 'Komentarnya telah disunting dibagian portfolio'
            ]);
            return 'Success';
        });

        Route::get('/comment/delete', function () {
            // $post = Post::find(1);
            // $post->comments()->where('id', 1)->delete();

            $portfolio = Portfolio::find(1);
            $portfolio->comments()->where('id', 2)->delete();

            return 'Success';
            
        });

        Route::get('/tag/read', function () {
            $post = Post::find(1);

            foreach ($post->tags as $tag) {
                echo $tag->name . '<br>'; 
            }

            // $portfolio = Portfolio::find(1);

            // foreach ($portfolio->tags as $tag) {
            //     echo $tag->name . '<br>'; 
            // }
 
            // return $post->tags; 
            
        });

        Route::get('/tag/attach', function () {
            // $post = Post::find(1);
            // $post->tags()->attach([1,2]);

            $portfolio = Portfolio::find(1);
            $portfolio->tags()->attach([7,8]);

            return 'Success';
            
        });

        Route::get('/tag/detach', function () {
            // $post = Post::find(1);
            // $post->tags()->detach([2,4]);

            $portfolio = Portfolio::find(1);
            $portfolio->tags()->detach([2,4]);

            return 'Success';
            
        });

        Route::get('/tag/sync', function () {
            $post = Post::find(1);
            $post->tags()->sync([1,2]);
    
            return 'Success';

        });
            
    