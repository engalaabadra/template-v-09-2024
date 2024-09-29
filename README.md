# My Template

## How to use:

  - clone the repo.
  - composer install
  - php artisan generate:key
  - php artisan optimize:clear
  - php artisan passport:install
  - php artisan storage:link
  - php artisan migrate:refresh --seed
    OR
  - php artisan migrate:refresh
  - php artisan db:seed

## Names Modules in this project:
    * for users pages
        - Geocode :
            for  Countries,Cities,States,Areas,Addresses

        - Profile
            for  profiles in website

        - Banner
            for  banners in website

        - Board
            for  boards in website

        - Chat
            for  chats in website

        - Contact
            for  contact in website

        - Favorite
            for  favorites in website

        - Notification
            for  notifications in website

        - RequestWithdrawing
            for  RequestWithdrawings in website

        - Review
            for  Reviews in website

        - Order
            for  orders in website

        - Payment
            for  payments in website

        - Wallet
            for  Wallets in website

        - Movement
            for  movements in website
        
    * for admin pages (management all prev. moduleس)
        - Auth :
            for management Users,Roles,Permissions


## Scopes (Local And Global) Traits And helpers :
    - Scopes:
        * global
            ActiveScope : for make active when status =1 in whole project
            LanguageScope 
        And to apply it on the whole project will put this method in App\Models\BaseModel.php file and will all model extends from this class BaseModel to excute these scopes and any thing in this file in all model
        ------------------------------------------------------------
        protected static function boot()
        {
            parent::boot();
            static::addGlobalScope(new ActiveScope);
            static::addGlobalScope(new LanguageScope);
        }
        ------------------------------------------------------------
## General file structure :
    - app
        - Helper
            auth.php
            constants.php
            media.php
            methods.php
            response.php
            validation_messages.php
        - Http
            - Controllers
                -API
                    -Auth
                        - Admin
                            LoginController
                        - User
                            LoginController
                            RegisterController
                        - RecoveryPasswordController
                        - FileController
                        - HomeController
            - Middleware
                - Localization
            - Requests
                - Auth
                    - User
                        - RegisterRequest.php
                    - CheckCodeRequest.php
                    - ForgotPasswordRequest.php
                    - LoginRequest.php
                    - ResetPasswordRequest.php
                - UploadFilesRequest.php
        - Jobs
            SendMessageJob.php
        - Listeners
            ChatMessageListener.php
        - Mail
            General.php
            Welcome.php
        - Models
            - Traits
                - Role
                    GeneralRoleTrait.php
                    RoleAttributes.php
                    RoleMethods.php
                    RoleRelations.php
                    RoleScopes.php            
                - User
                    GeneralUserTrait.php
                    UserAttributes.php
                    UserMethods.php
                    UserRelations.php
                    UserScopes.php
            BaseModel.php
            File.php
            Job.php
            PasswordReset.php
            Permission.php
            Role.php
            User.php
            PersonalAccessToken.php
            RegisterCodeNum.php

        - Providers
            TelescopeServiceProvider.php
        - Repositories
            - Auth
                - Login
                    - Admin
                        LoginRepository.php
                        LoginRepositoryInterface.php
                    - User
                        LoginRepository.php
                        LoginRepositoryInterface.php
                - Recovery
                    - Password
                        PasswordRepository.php
                        PasswordRepositoryInterface.php
                -Register
                    - User
                        RegisterRepository.php
                        RegisterRepositoryInterface.php
            EloquentRepository.php
            EloquentRepositoryInterface.php
        - Routing
            ResourceRegister.php
        - Scopes
            ActiveScope.php
            LanguageScope.php

        -Services
            GeneratePdfService.php
            PaymentMethodService.php
            ProccessCodesService.php
            SendingMessagesService.php
            SendingNotificationsService.php
            VonageCheckValidateNumber.php

        - Traits: 
            AuthTrait.php
            EloquentTrait.php
            GeneralAttributesTrait.php
            GeneralMethodsTrait.php
            GeneralTrait.php
            HandlerTrait.php
            MediaTrait.php
        for functions that use general in website
    - Modules
        - Banner
            - Config
            - Console
            - Database
            - Entities
                - Traits
                    - User
                        BannerMethods.php
                    BannerRelations.php
                    BannerScopes.php
                    GeneralBannerTrait.php
                    Banner.php
            - Http
                - Controllers
                    - API
                        - User
                            BannerResourceController.php
                    - Middleware
                    - Requests
                    - Providers
                    - Repositories
                        - API
                            - User
                                - Resources
                                    BannerRepository.php
                                    BannerRepositoryInterface.php
                        - WEB
                    - Resources
                        - User
                            BannerResource.php
                    - Routes
                        api.php
                        web.php
                    - Tests

    * And other modules have same structure approx.


# Technologies And Packages that were used:
## Authentication:
### Login And Register
    
    by using packages  sanctum and passport:

    these packages installed default in laravel 9 and 10 , but i will select passport , because  its contain many features more than sanctum 

    which is support OAuth , Apis token , but will need to keep the token in storage counter to sanctum (keep this token in auth in laravel default)

    but will use passport Because there are advantages in it more comprehensive than sanctum

    https://stoffel.io/blog/laravel-passport-vs-sanctum

    send into email or phone no.:
    by using  MAIL_HOST : smtp.gmail.com to send into email
    And Vonage to send into phone no.
    https://dashboard.nexmo.com/getting-started/sms

### Laratust : for roles, psermissions:

    - composer require "santigarcor/laratrust:3.2.*"
    - in config/app.php in providers array:
        Laratrust\LaratrustServiceProvider::class,
    - in config/app.php in aliases  array:
        'Laratrust'   => Laratrust\LaratrustFacade::class,
    - php artisan vendor:publish --tag="laratrust"
    - app/Http/Kernel.php in array : routeMiddleware 
    'role' => \Laratrust\Middleware\LaratrustRole::class,
    'permission' => \Laratrust\Middleware\LaratrustPermission::class,
    'ability' => \Laratrust\Middleware\LaratrustAbility::class,
    - in file laratrust_seeder.php will define permissions and roles
    ```
    'roles_structure' => [
        'superadmin' => [
         
        ],

        'permissions_map' => [

        ]
    ```

## HMVC:
    - composer require nwidart/laravel-modules

    - php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"

    or To publish only the config: 
 
    - php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider" --tag="config"

    - in composer.json in autoloading using psr-4 :
      "Modules\\": "Modules/"

    - composer dump-autoload

    - php artisan module:make Auth 

### using package for optimizing:
        https://laravel.com/docs/11.x/telescope
        - composer require laravel/telescope --dev
```
"laravel/telescope": "^5.2",
    && 
"extra": {
    "laravel": {
        "dont-discover": [
            "laravel/telescope"
        ]
    }
},
```
        * in db
        - php artisan telescope:install
        - php artisan migrate

        * In register() in app service provider
```
            if ($this->app->environment('local')) {
                  $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
                  $this->app->register(TelescopeServiceProvider::class);
              }
```
        * Examples in methods
            * login
                public function checkLogin($request){
                    $user = User::where('email', 'like',  $request->get('email'))
                                ->orWhere(function($query) use ($request) {
                                    $query->where('phone_no', $request->get('phone_no'))
                                        ->where('country_id', $request->get('country_id'));
                                })
                                ->first();
                    $roles= $user->roles->pluck('name')->toArray();
                    if(!in_array('user',$roles)) return trans('messages.Invalid credentials');
        
                }
```
            --- to optimize this method:
                    public function checkLogin($request)
                    {
                        $user = User::with('roles:name')
                                    ->where(function ($query) use ($request) {
                                        $query->where('email', $request->get('email'))
                                              ->orWhere(function ($query) use ($request) {
                                                  $query->where('phone_no', $request->get('phone_no'))
                                                        ->where('country_id', $request->get('country_id'));
                                              });
                            })
                            ->first();
                        if(!$user || !$user->roles->contains('name','user')) return trans('messages.Invalid credentials');

                    }
```
    -- to showing excution this package :
        http://127.0.0.1:8000/telescope/requests

### caching
***What is Caching in Laravel?***
        
    Caching in Laravel allows you to store data temporarily to reduce the number of queries to a database or an external service. This improves the application's speed and performance by retrieving frequently accessed data from memory rather than hitting the database repeatedly.

Laravel provides several cache drivers out of the box, such as file, database, redis, memcached, and more. By default, Laravel uses the file cache driver.
```
    ** using default : file
        - in .env file
            CACHE_DRIVER=file
```
```    
    ** using redis
        - composer require predis/predis
        - in file .env
            CACHE_DRIVER=redis
            REDIS_HOST=127.0.0.1
            REDIS_PORT=6379
```
```
    *  Basic Cache Operations
        - Storing data in cache:
            Cache::put('key', 'value', $seconds); // Store a value for a specific duration
        - Retrieving data from cache:
            $value = Cache::get('key');
        - Storing data indefinitely:
            Cache::forever('key', 'value'); // The value stays until manually deleted
        - Deleting from cache:
            Cache::forget('key');
        - Cache::remember($key, $sec, $clouser fun);// checks if the cache key  exists. If it       doesn't, it executes the closure, stores the result in the cache, and returns it. The cached data will be available for  seconds (1 hour).
```
***Cache Example***
```
        - Storing Data in Cache
            Cache::put('user_data', $user, 600); // Store user data for 10 minutes (600 seconds)
        - Retrieving Data from Cache
            $user = Cache::get('user_data', function() {
                        // Fetch data from database if it's not in the cache
                        return User::find(1);
                    });
        - Deleting Cache
            Cache::forget('user_data');
        - in controller:
            public function index()
            {
                $users = Cache::remember('users', 3600, function () {
                    return User::all();
                });

                return view('users.index', compact('users'));
            }
```
 ***another ex.***
 ```
            - in controller:
                Cache::put('latest_posts', Post::latest()->take(10)->get(), 600); // Cache latest 10 posts for 10 minutes
            - Retrieving Cached Data:
                $latestPosts = Cache::get('latest_posts');
            - Testing Cache in Code:
                - Store the data in cache:
                    Cache::put('cached_data', 'This is a test', 600); // Store data for 10 minutes
                - Retrieve the data:
                    $data = Cache::get('cached_data');
                    dd($data); // Check the result in your browser
```
***Tagging Cache***

        to group related cache data. Such as : key  cache has many tags and same tags possible used via other keys cache .
        - Cache::tags(['people', 'artists'])->put('user', $user, 600); // Cache a user in the "people" and "artists" tag group

        - Retrieving cached data using tags:
            $user = Cache::tags(['people', 'artists'])->get('user');
    ** Clearing Cache
        php artisan cache:clear

    By following these steps, you can efficiently cache data in Laravel, improving performance by reducing the number of database queries or external service calls.

### Jobs & Queue & Corn Jobs
    * job :
        to handle time-consuming operations without blocking the user interface (excuting in background) , which is this code will put in handle method in this job .
        Use in -> sending emails, processing images, or interacting with external APIs.

        -- create job -> php artisan make:job SendingEmailJob

        And must class job implements ShouldQueue

        To calling this job via : dispatch OR after a specific time -> schedule job in laravel app(Or corn job in server) 
        Like : 
           Normal Job -> dispatch(new SendingEmailJob($email,$type,$data));
           or if want determine type a queue -> dispatch(new SendingEmailJob($email,$type,$data))->onQueue('import');
           **to excute it** php artisan queue:work

           Schedule Job - $schedule->job(new AssignSessionItemsJob(authUser()))->everyMinute();
           in method schedule in App\Console\kernel.php
           **to excute it** php artisan schedule:run Or :work -> to watch any changes

        Command :
        *** Diff. between schedule job & Corn  ***
            Both using same file schedule job &  excute after a specific time but the diff. in excuting which is :
            ** schedule job ** use in laravel app , So command -> 
            php artisan schedule:run
            ** Corn job ** use in server , So command -> 
            * * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1

        
    * Queue :
        when using job will use queue to make management between jobs in background to improve the performance of application .
        Must run queue to run all jobs that inside this queue
        Command :
        -- php artisan queue:table
        -- php artisan migrate && will write type database in file .env : QUEUE_CONNECTION=database
        -- to run queue that inside it this job -> php artisan queue:work
            OR php artisan queue:listen -> to watch any changes
        php artisan queue:work --emails -> this run queue just in this type so not excute all jobs , only jobs that determine type queue - emails Like : dispatch(new SendingEmailJob($email,$type,$data))->onQueue('emails');
        this will create in table jobs a row for type this queue : emails not default

    #### Summery (Jobs - Queue - Scheual) ###
        Jobs: Represent individual tasks.
        Queues: Manage the asynchronous execution of jobs.
        Cron Jobs: Schedule tasks to run at specific times or intervals, which can include dispatching jobs.
        Each of these components plays a crucial role in making Laravel applications more efficient and manageable, especially when dealing with background processing and task scheduling.
### Events & Listiners
    * Definition
        * Events : classes that represent actions occur in  the website
        * Listiners : classes that respond to events. When an event is fired, the associated listeners are executed to handle the event's logic.
    * Creation
        Event : php artisan make:event UserRegistered
        Listiner : php artisan make:listener SendWelcomeEmail
    * Usage
        Listiner : in method handle
                    Mail::to($event->user->email)->send(new WelcomeEmail());
        event : event(new UserRegistered($user));
#### Broadcast
    use in real time , such as : websocket 
    which is use in event class to make real time 
    Which is , when occur this event will go into website pusher or redis (servers support realtime) ->  to notify clients about changes or updates in real-time
    * Usage :
    in file event
    - class UserRegistered implements ShouldBroadcast

    - public function broadcastOn()
        {
            return new Channel('users');
        }
    - calling this event via broadcast
        event(new UserRegistered($user));
    - to excute realtime ( client side)
        Echo.channel('users')
        .listen('UserRegistered', (e) => {
            console.log('User registered:', e.user);
        });

    ### Summary(Events - Listeners - Broadcasting) ###
        Events: Represent occurrences in your application and are dispatched when they happen.
        Listeners: Respond to events and contain the logic to handle them.
        Broadcasting: Allows you to send events to client-side applications in real-time, enhancing interactivity.
    Using events, listeners, and broadcasting together allows for a clean, modular, and reactive application architecture in Laravel.
    
    https://laravel.com/docs/10.x/broadcasting#pusher-channels
    
##### WebSocket 
    WebSocket is a protocol 
    - Real-Time Communication: that enables full-duplex communication channels (2 way comm. between client & server) making realtime apps. like : chat apps or live apps
    - Efficiency: Reduces the overhead of HTTP by keeping the connection open, allowing for  faster message exchange.
    - Browser Support: Supported by modern web browsers and can be used in various programming environments.
    ** diffention with event : **
    Broadcast server support real time , which is connect between many clients shared with this server , any msg come into this server will go into all these clients
    And when occur an event that  waiting for an a client , this client recieve this event via websocket ->realtime

#### Socket.IO
    A JavaScript library that enables real-time between client & server.
    That enhances the capabilities of WebSocket with additional features like fallbacks, event handling, and broadcasting.

### Notification : channels -> broadcast(realtime) - database - mail - nexmo(sms) - slack
- public function via($notifiable){
        $via = ['broadcast','database','mail'];
        if($notifiable->notify_mail){
            $vai[] = 'mail';
        }
        if($notifiable->notify_nexmo){
            $vai[] = 'nexmo';
        }
        return $via;
    }

#### in Broadcast 
like event ->listen an event  when occur action will excute event (send notifications to users) 
** In server side
    - in .env
        BROADCAST_DRIVER=pusher
    - enabel broadcast in config\app.php:
        in arr providers -> 
        Illuminate\Broadcasting\BroadcastServiceProvider::class,
    
    - public function toBroadcat($notifiable)
        {
            $body = ;
            return new BroadcastMessage([
                'title'=> ,
                'body'=> ,
                'icon'=> ,
                'url'=>
            ]);
        }
    *** brodcast contain 3 channels : 
    public: all clients that connect with this channel-> recieving msgs
    private : only clients that have auth in this channel to recieving msgs
    presnence: same private , only give infos. about these clients
    SO now will determine type channel for broadcast:

    - Brodacast::channel('App.Models.User.{id}',function($user,$id)){
            return (int) $user->id === (int) $id;
        }
    in this step will send the msg into pusher server realtime , but if i need see this realtime in client side will next steps.
***in client side*** (echo ->make real time in client side)

    - npm i laravel-echo pusher-js -dev
    - in bootstrap.js:
        import Echo from 'laravel-echo';
        window.Pusher = require('pusher-js');
        window.Echo = new Echo({
            broadcaster : 'pusher',
            key: proccess.env.MIX_PUSHER_APP_KEY,
            cluster: proccess.env.MIX_PUSHER_APP_CLUSTER,
            forceTLS: true
        });
    - listen for event notification:
     in app.js:
        require('./boostrap');
        require('alpinejs')
        window.Echo.private(`App.Models.User.${userId}`)
            .notification(function(data)){
                alert(data.body)
            }
    - in layouts/app.blade.php
        <script>
            const userId = "{{Auth::id()}}"
        </script>
        <script src="{{asset('js/app.js')}}"></script>
    
    ** when user connect with the channel will pass in 3 levels :
        occupied : wait accour an action to make an event in pusher server
        disconnected: disconnect this client with channel
        subscried : now will be connection 
        connected : connected with channel
    - render notifications in front after test via alert will render here:
        <div>
        <ul>
            @foreaach($notifications as $notification)
                <li>
                    <a href=""></a>
                    <span class="notification-icon"></span>
                    <span class="notification-text">
                        @if($notification->unread())
                        <strong>*</strong>
                        @endif
                        {{$notification->data['body']}}
                    </span>
                </li>
            @endforeach
        </ul>
        </div>
    - update on this , instead alert will write this:
        window.Echo.private(`App.Models.User.${userId}`)
            .notification(function(data)){
                $('#notificationList').preappend(`<li class="notifications-not-read">
                <a href="${data.url}?notify_id=${data.id}">
                    <span class="notification-icon"></span>
                    <span class="notification-text">
                        <strong>*</strong>
                        ${data.body}
                    </span>
                </a>    
                </li>`);
                let count = Number($('#newNotifications').text())
                count++;
                if(count>99){
                    count = '99+'
                }
                $('#newNotifications').text(count)
            }
** another server deal with broadcast not only pusher , local server
https://beyondco.de/docs/laravel-websockets/getting-started/introduction

#### Database 

    - create table notification : php artisan notifications:table & php artisan migrate
    - create notification: php artisan make:notification 
    -  public function toDatabase($notifiable)
        {
            $body = ;
            return new BroadcastMessage([
                'title'=> ,
                'body'=> ,
                'icon'=> ,
                'url'=>
            ]);
        }
    - calling noti. :  $ ->user->notify(new ); or Notification::send( , new );

    - get notifications :
    $user->unreadNotifications()->count();

    - to make as read when click on an noti.:

    * make middleware : MarkNotificationAsRead & add it in middleware arr in kernel & in routes web or api & in routeMiddleware arr -> to put this moiddlware in route click this noti.

    * file notification middleware
        class MarkNotificationAsRead
        {
            public function handle(Request $request , Closure $next){
                $user = $request->user();
                $notify_id = $request->query('notify_id');
                if($notify_id){
                    $notification = $user->unreadNotifications()->find($notify_id);
                    if($notification){
                        $notification->markAsRead();
                    }
                }
            }
        }

#### Mail
    - setup in .env

    -  public function toMail($notifiable)
        {
            $body = ;
            $message =  new MailMessaage;
            $message->subject('')
                    ->from('','')
                    ->greeting('')
                    ->line($body)
                    ->action('',route(''))
                    ->line('')
                    ->view('mails.',[

                    ]);
            return $message;
        }
    - php artisan vendor:publish --tag=laravel-mail
    - php artisan vendor:publish --tag=laravel-notifications

## Multiple payment gateways
can enhance flexibility and provide users with various payment options

***Usage***

    interface PaymentGatewayFactory{
        public function create($order,$user) : string;
        public function verify() : Payment;
    }
    - which is meth. create will calling it , when click checkout to show multi payment gateways to select from it , to store payment_method_id & session_id ... in table payments & session this user , will take these data into sec. step -> verify(callback)->when click on pay now after enter all data payment card this user 

    ** methods in this interface must be in all classes implement this interface such as : Paypal , Thawani , strip
    - create meth. : when click on checkout to showing page payment gateway to select from it to showing after it the page payment 

    contain on :
    setDataPayment -> every payment gateway diffenerent about the other , according on doc. in every payment gateway
    like this :
    protected function setDataPayment($order,$user){
            $data['amount']= $order->price;
            $data['currency']= systemCurrency();
            $data['customer']['first_name']= $user ? $user->full_name : null;
            $email = $user ? $user->email : null;
            if(!$email) $email = $user ? $user->full_name.' '.'#'.$order->id.'@template.net' : null;
            $data['customer']['email']= $email;
            $data['customer']['phone']['number']= $user ? $user->phone_no : null;
            $data['source']['id']= "src_all";
            return $data;
        }
After this setDataPayment will calling execute meth for this data to take response 
like this :
```
$response = $this->client->execute($data);
```
And from this response will take url for callback url
And will create payment in db(payment_id from input data,session_id from response) & in session
- verify meth. : when click on pay now
 will getdata payment to enter into execute meth.
 like this: 
```
    $response = $this->client->execute($request);
```
And meth. getDataPayment
//get payment , payment method , transaction
```
    protected function getPayment(){
        $paymentMethodSlug = Session::get('payment_method_id');
        $paymentMethod = PaymentMethod::where('slug',$paymentMethodSlug)->first();
        if(!$paymentMethod) return trans('messages.this slug payment method not found , pls select again');
        $transactionId = Session::get('transaction_id');
        $payment = Payment::where(['transaction_id'=>$transactionId])->first();
        if(!$payment) return 404;
        return [
            'payment_method'=>$paymentMethod,
            'payment'=>$payment,
            'transaction_id'=>$transactionId
        ];
    }

from the response meth. excute will take status from this result as this:

if($response->result->status == 'COMPLETED'){
    $payment = $this->updatePayment($resultPayment,$response,1);
}elseif($response->result->status == 'CANCELED'){
    $payment = $this->updatePayment($resultPayment,$response,-1);
}
Session::forget(['payment_id','session_id']);

Any project need into multi payment gateways or one payment gateway , 
Anything general we can make specific, but anything specific we cannot generalize. From this perspective, we will use this senario 
which is when use  payment gateway , will be payment method id = 1 always & will focus on 1 file payment method like Stripe just 
```

### Scopes 
a way to apply query logic for eloq. models 

### Global Scope 
a query constraint applied Automatically  to all queries of a model, ensuring certain conditions are always met. Useful for persistent constraints.
 , but when i need except it will use this keyword withoutGlobalScope as this :
```
$role->users()->withoutGlobalScope(ActiveScope::class)->withoutGlobalScope(LanguageScope::class)->paginate(total());
```

***Implementation***
- create App\Scopes\ActiveScope
```
class ActiveScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        $builder->where('active', 1);
    }
}
```
- Apply the Global Scope to a Model:
in model User ex.:
```
protected static function booted()
    {
        static::addGlobalScope(new ActiveScope);
        //static ::addGlobalScope('active', function(Builder $builder){
        //    $builder->where('status','=','open');
        //});
        static ::addGlobalScope('myProducts', function(Builder $builder){
            $builder->where('user_id','=',Auth::user()->id);
        }); //when any get query automaticly will get that for this user like in project store -> get all products only that i have it

    }
```
OR will will apply in model general and will all models will extends from this model , like App\Models\BaseModel
```
class BaseModel extends Model
{
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new ActiveScope);
        static::addGlobalScope(new LanguageScope);
    }
}
```
meth. boot : meth in laravel use to make initialization operations for models like ServiceProvider : boot for whole app
So any conditions inside it will applying automaticly

- $builder : instance from query builder , which is alwaysany model when build any query , use inside it : query builder


***Usage***
```
$users = User::all(); // Automatically filtered to only active users
```
in filer:
```
public function scopeFilter(Builder $builder, $filters){
    $filters = array_merge([
        'type'=>null,
        'status'=>null,
        'budget_min'=>null,
        'budget_max'=>null,
    ],$filters);
    if($filters['type']){
        $builder->where('type','=',$filters['type']);
    }
    if($filters['status']){
        $builder->where('status','=',$filters['status']);
    }
    if($filters['budget_min']){
        $builder->where('budget_min','=',$filters['budget_min']);
    }
    if($filters['budget_max']){
        $builder->where('budget_max','=',$filters['budget_max']);
    }
}
```
use filter scope:
```
$user->posts()->filter(['status'=>1,'budget_min'=>2000])
```
#### SoftDelete
Are implemented using a global scope in Laravel , because applied automaticly on model. 
```
$users = User::all(); // This will NOT include soft deleted users (Taking into consideration condition in softdelete scope)
```

and if i need without this global scope will use : (Not Taking into consideration condition in softdelete scope) -> withTrash instead withoutGlobalScope

```
$allUsers = User::withTrashed()->get(); // This includes soft deleted users
```


### Local Scope
a query constraint  applying Manually applied when needed, allowing for reusable query logic without affecting other queries.
means that : to apply it in a query , must calling it , when not calling it dont apply on this query that in this model that contain this scope
***Implementation***
```
public function scopeType($query)
{
    return $query->where('type', 1);
}
public function scopeMyProducts($query)
{
    return $query->where('user_id', Auth::user()->id);
}
public function scopeHigh(Builder $builder){
    $builder->orderBy('budget','DESC');
}
```
***Usage***
```
 Post::type()->get(); //get only post have type = 1
 ::myProducts()->get();//get products only that i have it
 $user->projects()->high();//get projects that have high buget (order by desc)
```
Both Local & global scopes will write method scope in the model , but difference in implementation method & usage 
in usage : global-> when get data from model automaticly get data with taking consideration condition that inside global scope method , and if i need without it , will write withoutGlobalScope
local -> when get data from model , not automaticaly with condition in local scope , while must determining

## Accessors & Mutators
### Accessors 
A way to displaying values from db in a specific 
syntax : must start with keyword->get & end with keyword -> Attibute & between it keyword attribute that stored in db like -> status or -> profile_photo , & must this attr. start char -> capitil letter
or possible write any word between keywords(get,Attribute) , but must use same keyword attr. after keyword $this that inside fun.

```
Ex.:
public function getProfilePhotoAttribute(){
    if($this->profile->profile_photo) return asset('storage/' . $this->profile->profile_photo);
    else return asset('images/default-photo.jpg');
}
```
***Usage***
```
$user->profile->profile_photo
```
-----------------------------------
OR 
```
public function getNameAttribute($value)
{
    return ucfirst($value);
}
```
***Usage***
```
    $user->name 
Output: Engalaa instead engalaa
    To get all names in capital letter
``` 
-------------------------------------
OR
```
public function getActiveAttribute()
{
    return $this->attributes['active'] ?? null;
}
public function getOriginalActiveAttribute()
{
    return isset($this->attributes['active']) 
        ? trans($this->attributes['active'] ? 'attributes.Active' : 'attributes.Not Active')
        : null;
}
```
***Usage***

    $user->active : 1 or 0 , $user->originalActive : Active or NotActive
Which is :
getActiveAttribute this to keep original value when i use it 
getOriginalActiveAttribute to appear value that i need it to appear like : Active or NotActive


### Mutators
A way to entering values into db in a specific 
```
Ex. :
public function setPasswordAttribute($value)
{
    $this->attributes['password'] = hashData($value);
}
```
## Service Providers & Service Containers & Facade 

```
class AppServiceProvider extends ServiceProvider{
    public function register(){
        $this->app->bind('currency', function($app){
            return config('app.currency');
        })
    }
}
```

### Facade
static classes , when using it , will calling object in service container connect with this facade
Like :
** original Facade:
```
class App extends Facade{
    //method in class Facade
    protected static function getFacadeAccessor(){
        return 'app';
    }
}
```
```
class Currency extends Facade{
    protected static function getFacadeAccessor(){
        return 'currency';// this is name var. or fun. in service container , will return inside this var. currency
    }

}
```
So , ways to storing data constant:
- Service Container -> calling it via :
```
App::make('currency');
Or
app('currency')
```
- Facade -> calling it via:
Currency
- Helper

###  Database relationships, especially with foreign keys,
#### restrict, set null, cascade, and no action
#### Restrict
- if there are forign keys (subs)  , Prevents deletion Parent of a record
```
Schema::table('orders', function (Blueprint $table) {
    $table->foreignId('user_id')->constrained()->onDelete('restrict');
});//RestrictOnDelete
```
#### Set Null
- if there are forign keys (subs) , Sets  foreign keys field(sub) to NULL when the Parent is deleted.
```
Schema::table('orders', function (Blueprint $table) {
    $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');//SetNullOnDelete()
});
```
#### Cascade
- if there are forign keys (subs) , Automatically deletes the forign keys records when the parent record is deleted.
```
Schema::table('orders', function (Blueprint $table) {
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
});//CascadeOnDelete
```
#### No Action
-  No specific action; behaves like restrict in practice.
```
Schema::table('orders', function (Blueprint $table) {
    $table->foreignId('user_id')->constrained()->onDelete('no action');
});//NoActionOnDelete
```

### Commands To managing database migrations in laravel
- migrate:fresh
Drops all tables and re-runs all migrations , All data is lost

- migrate:refresh (rollback+ migrate)
Rolls back all migrations -> excute that inside method down() ,and re-runs them  in all files migration, All data is lost

- migrate:status
Shows the status of all migrations (whether they are run or not) ,  No effect on data.
- migrate:rollback
Rolls back the last batch of migrations ->excute that inside method down() in file migration, data related to thse migrations may be lost
- migrate:reset
Rolls back all migrations to the initial state (empty db approx.) ->excute that inside method down() in all files migration, all data is lost

![alt text](image.png)

rollback -> rollback for last batches
resfresh -> rollback all & migrate
fresh -> delete & migrate
reset ->  rollback all

Batch : arrangement excution migrations 

### Relation In Laravel
![alt text](image-1.png)

### One-to-One Relationship
 relationship is where a single record in one table is associated with a single record in another table.
***Example*** 
A User has one Profile
***Database Tables*** 
users and profiles (the profiles table has a user_id foreign key)
```
class User extends Model
{
    public function profile()
    {
        return $this->hasOne(Profile::class);
    }
}
```
```
class Profile extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
```
***Usage***
```
$profile = User::find(1)->profile; // Fetch the profile associated with user ID 1
```
### One-to-Many Relationship
relationship is where a single record in one table is associated with multiple records in another table.
***Example***
A Post has many Comments
***Database Tables***
posts and comments (the comments table has a post_id foreign key)
```
class Post extends Model
{
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
```
```
class Comment extends Model
{
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
```
***Usage***
```
$comments = Post::find(1)->comments; // Fetch all comments for post ID 1
```

### Many-to-Many Relationship
relationship is where records in both tables are associated with multiple records in each other. This relationship requires an intermediate pivot table to store the relationship.
***Example***
A User can have many Roles, and a Role can belong to many Users
***Database Tables***
users, roles, and role_user (pivot table with user_id and role_id)
```
class User extends Model
{
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
```
```
class Role extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
```
***Usage***
```
$roles = User::find(1)->roles; // Fetch all roles for user ID 1
$users = Role::find(1)->users; // Fetch all users with role ID 1
```

#### Has Many Through (Indirect Relationships)
relationship defines a relationship that is indirectly linked via another intermediate model.

***Example*** 
A Country has many Posts through Users
***Database Tables*** 
countries, users, and posts (posts belong to users, users belong to countries)
```
class Country extends Model
{
    public function posts()
    {
        return $this->hasManyThrough(Post::class, User::class);
    }
}
```
***Usage***
```
$posts = Country::find(1)->posts; // Fetch all posts related to a specific country through its users
```


#### 5. Polymorphic Relationships
allow a model to belong to more than one model on a single association.
***Example***
A Photo can belong to either a User or a Post (i.e., the same Photo model can be used by both Users and Posts)
***Database Tables***
photos, users, posts, with photos having imageable_id and imageable_type fields
```
class Photo extends Model
{
    public function imageable()
    {
        return $this->morphTo();
    }
}
```
```
class User extends Model
{
    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }
}
```
```
class Post extends Model
{
    public function photos()
    {
        return $this->morphMany(Photo::class, 'imageable');
    }
}
```
***Usage***
```
$photos = User::find(1)->photos; // Fetch all photos for user ID 1
$photos = Post::find(1)->photos; // Fetch all photos for post ID 1
```

#### Many-to-Many Polymorphic Relationships
polymorphic relationships but for many-to-many relations.
***Example***
A Tag can belong to both Posts and Videos
***Database Tables***
tags, taggables, posts, videos (the taggables table has tag_id, taggable_id, and taggable_type)
- Model Tag
```
class Tag extends Model
{
    public function posts()
    {
        return $this->morphedByMany(Post::class, 'taggable');
    }

    public function videos()
    {
        return $this->morphedByMany(Video::class, 'taggable');
    }
}
```
- Models Video , Post
```
class Post extends Model
{
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}

class Video extends Model
{
    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
```
***Usage***
```
$tags = Post::find(1)->tags; // Fetch all tags for post ID 1
$tags = Video::find(1)->tags; // Fetch all tags for video ID 1
```
--- Like Model File -> relation with all models (fileable_id , dileable_type->name of model)
## Programmer:

- Eng-Alaa Badra (Laravel Developer).

