<div>
    <x-filament::section>
        <form wire:submit="create" style="margin-bottom: 18px">
            {{ $this->form }}

            <x-filament::button type="submit" class="mt-3">
                {{ __('filament-panels::resources/pages/create-record.form.actions.create.label') }}
            </x-filament::button>
        </form>

        <x-filament::section :heading="$this->getHeader()">

            <div class="comment-container" style="width: 100%">

                @foreach ($comments as $comment)
                <div class="single-comment"
                    style="width: 100%; display: flex; flex-direction: column; margin-bottom: 40px">


                    <div class="user-info" style="display: flex; align-items: center; margin-bottom: 8px">


                        <img src="https://www.w3schools.com/howto/img_avatar2.png"
                            style="border-radius: 50%; height: 30px; width: 30px; margin-right: 10px">
                        <div class="username" style="margin-right: 10px; font-size: 18px">{{ $comment['author']['name']}}</div>
                        <div class="time" style="font-size: 15px; color: gray">
                            {{\Carbon\Carbon::createFromTimeStamp(strtotime($comment['created_at']))->diffForHumans() }}
                        </div>
                    </div>
                    <div class="message" style="margin-left: 40px">
                        {{$comment['content']}}
                    </div>
                </div>
                @endforeach
            </div>


            @vite('resources/js/app.js')
            <script>
                setTimeout(() => {
                    window.Echo.channel('commentChannel')
                    .listen('commentEvent', (e) => {
                        console.log(e);
                        console.log(e.user);
                        console.log(e.user.name);
                        console.log(e.comment);

                        if (e.user) {
                            console.log('yeeeeees');
                            const commentsContainer = document.querySelector('.comment-container');
                            // Create single-comment div
                            const singleComment = document.createElement('div');
                            singleComment.className = 'single-comment';
                            singleComment.style.cssText = 'width: 100%; display: flex; flex-direction: column; margin-bottom: 40px';

                            // Create user-info div
                            const userInfo = document.createElement('div');
                            userInfo.className = 'user-info';
                            userInfo.style.cssText = 'display: flex; align-items: center; margin-bottom: 8px';

                            // Create img
                            const img = document.createElement('img');
                            img.src = 'https://www.w3schools.com/howto/img_avatar2.png';
                            img.style.cssText = 'border-radius: 50%; height: 30px; width: 30px; margin-right: 10px';

                            // Create user-info div
                            const username = document.createElement('div');
                            username.className = 'username';
                            username.style.cssText = 'margin-right: 10px; font-size: 18px';
                            username.innerHTML = e.user.name;

                            // Create time div
                            const time = document.createElement('div');
                            time.className = 'time';
                            time.style.cssText = 'font-size: 15px; color: gray';
                            time.innerHTML = e.created_at;


                            userInfo.appendChild(img);
                            userInfo.appendChild(username);
                            userInfo.appendChild(time);


                            // Create message div
                            const message = document.createElement('div');
                            message.className = 'message';
                            message.style.cssText = 'margin-left: 40px';
                            message.innerHTML = e.comment;

                            singleComment.appendChild(userInfo)
                            singleComment.appendChild(message)
                            commentsContainer.appendChild(singleComment);
                        }
                    })
                }, 200);
            </script>


        </x-filament::section>
    </x-filament::section>

</div>
