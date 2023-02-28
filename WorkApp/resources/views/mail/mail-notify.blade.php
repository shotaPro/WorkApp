<x-mail::message>
# Introduction

おめでとうございます。
{{ $user_name }}さんに仕事の依頼することが確定しました。

<x-mail::button :url="''">
Button Text
</x-mail::button>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
