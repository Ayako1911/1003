@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">
        メモ編集
        <form class="card-body" action="{{ route('destory') }}" method="POST">
            @csrf
            <input type="hidden" name="memo_id" value="{{ $edit_memo[0]['id'] }}" />
            <button type="submit">削除</button>
        </form>
        </div>
        {{-- 「web.php」に->name('home');書いておくと、「action="/store"」が{{ route('store') }}に書き換えてくれる！--}}
            <form class="card-body" action="{{ route('update') }}" method="POST">
                @csrf
                <input type="hidden" name="memo_id" value="{{ $edit_memo[0]['id'] }}"/>
                <div class="form-group">
                    <textarea class="form-control" name="content" rows="3" placeholder="ここにメモを入力">{{ $edit_memo[0]['content'] }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary">更新</button>
            </form>
    </div>
@endsection
