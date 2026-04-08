@extends('layouts.app')

@section('content')

<h1 class="mb-4">タスク一覧</h1>

<div class="mb-3">
  <a href="{{ route('todos.create') }}" class="btn btn-primary"> ＋ 新しいタスクを追加
  </a>
</div>

<table class="table table-striped table-bordered table-hover bg-white">

  <thead class="table-dark">
    <tr>
      <th>ID</th>
      <th>タイトル</th>
      <th>状態</th>
      <th>期限</th>
      <th>操作</th>
    </tr>
  </thead>

  <tbody>
    @foreach ($todos as $todo)
    <tr>
      <td>{{ $todo->id }}</td>

      <td>{{ $todo->title }}</td>

      <td><span class="badge bg-secondary">{{ $todo->status }}</span></td>
      <td>{{ $todo->due_date }}</td>

      <td>
        <a href="{{ route('todos.show', $todo->id) }}" class="btn btn-info btn-sm text-white ms-1">
          詳細
        </a>

        <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-warning btn-sm ms-1">
          編集
        </a>

        <form action="{{ route('todos.destroy', $todo->id) }}" method="POST" class="d-inline">
          @csrf
          @method('DELETE') <button type="submit" class="btn btn-danger btn-sm ms-1" onclick="return confirm('本当に削除しますか？')">
            削除
          </button>
        </form>
      </td>
    </tr>
    @endforeach
  </tbody>

</table>

@endsection
