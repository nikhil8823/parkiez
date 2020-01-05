<p>
    Hello,<br><br>
    @if(isset($link))
        Password for your parkiez account:{{$password}}<br>
        Login in to parkiez: <a <?php echo "href=".url($link); ?>>{{url($link)}}</a><br><br>
    @endif
    Thanks <br><br>
    If you have any questions, comments or suggestions for improvement, please feel free to contact us.
</p>