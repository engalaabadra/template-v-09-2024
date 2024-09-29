@extends('emails.layouts.main')
@section('meta')
    <title> Welcome </title>
@endsection
@section('main-container')

        <p>Dear  : {{$emailData['email']}}</p>
        <p>
            This is code : {{$emailData['message']}}
            نحن نرحب بك في تطبيق تلبينة للرعاية الطبية، حيث نسعى جاهدين لتوفير أفضل الخدمات الصحية والطبية لك. نحن سعداء لأنك انضممت إلينا، ونعدك بأن تجربتك معنا ستكون سهلة ومريحة.
        </p>
        <p>
            تطبيق تلبينة يتيح لك الوصول إلى العديد من الخدمات الصحية بكل سهولة ويسر، بما في ذلك:
        </p>
        <ul>
            <li>حجز مواعيد مع أطبائنا المتميزين.</li>
            <li>التواصل مع فريقنا الطبي وطلب استشارات عبر الإنترنت.</li>
        </ul>
        <p>
            نحن نهدف إلى تحقيق أعلى معايير الجودة والرعاية الصحية لمساعدتك في الحفاظ على صحتك ورفاهيتك. إذا كنت بحاجة إلى أي مساعدة أو توجيه أثناء استخدام التطبيق، فلا تتردد في الاتصال بفريق دعم العملاء لدينا.
        </p>
        <p>
            نحن نتطلع إلى خدمتك وتقديم الرعاية الصحية التي تستحقها. شكرًا لثقتك بنا.
        </p>


@endsection
