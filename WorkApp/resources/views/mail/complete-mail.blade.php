<x-mail::message>
# Introduction

{{ $name }}さんが納品完了を行いました。

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
