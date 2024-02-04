<script src="{{ URL::asset('assets/bundles/libscripts.bundle.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset('assets/bundles/vendorscripts.bundle.js') }}" type="text/javascript"></script>

<script src="{{ URL::asset('assets/bundles/mainscripts.bundle.js') }}" type="text/javascript"></script>
<script>
  var APP_URL = "{{ url('') }}";
</script>
@stack('scripts')
