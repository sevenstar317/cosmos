@extends('layouts.agents')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
                    <!-- Modal -->
                    <div class="modal fade ppp" id="personal-map-modal-id" tabindex="-1" role="dialog" aria-labelledby="personal-map-modal-label">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content text-center">
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    <h4 class="modal-title">Astrology Info Cente</h4>
                                </div>
                                <div class="modal-body">



                                </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('.ppp').modal();
    });
</script>
@endsection
