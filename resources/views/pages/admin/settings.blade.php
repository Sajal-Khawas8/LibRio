@extends("layouts.admin-panel-layout")

@section("admin")
<section class="py-8 space-y-10">
    <h1 class="text-center text-4xl font-semibold">Account Settings</h1>
    <x-shared.settings update="{{ route('admin.settings.profile.edit') }}" delete="{{ route('admin.settings.profile.delete') }}" />
</section>
@endsection