<table class="table table-bordered">
    <thead>
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>E-mail</th>
        <th>Created</th>
    </tr>
    </thead>
    <tbody id="userList">

    </tbody>
</table>
<div class="col-12">
    <div class="float-left">
        <span class="badge badge-secondary">Total <span id="total"></span> Records</span>
    </div>
    <div class="float-right">
        <nav aria-label="Page navigation" id="pagination-nav" style="display: none">
            <ul class="pagination">
                <li class="page-item" id="first-item">
                    <a class="page-link" href="#" aria-label="First">
                        <span aria-hidden="true">&laquo;</span>
                        <span class="sr-only">First</span>
                    </a>
                </li>
                <li class="page-item" id="previous-link">
                    <a class="page-link" href="#"> <?= $page - 1 ?></a>
                </li>
                <li class="page-item active" id="current-link">
                    <a class="page-link" href="#" ><?= $page ?></a>
                </li>
                <li class="page-item" id="next-link">
                    <a class="page-link" href="#" > <?= $page+1 ?></a>
                </li>

                <li class="page-item" id="last-item">
                    <a class="page-link" href="#" aria-label="Last">
                        <span aria-hidden="true">&raquo;</span>
                        <span class="sr-only">Last</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

</div>
<script>
    $(document).ready(function () {
        var url = '<?= $this->Url->build(['controller' => 'home', 'action' => 'users',"?" => ["page" => $page,'limit'=> $limit,'format' => 'json']],['escape' => false]) ?>';
        UTILITY.ajaxLoadCallback(url,function (response) {
            if(!isEmpty(response.status) && response.status == 'error'){
                toastr.error(response.message);
            }
            else if(!isEmpty(response.status) && response.status == 'success'){
                var data = response.data;
                var offset = (!isEmpty(data.offset))?data.offset:0;
                var html = '';
                var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
                $.each(data.records,function (i,v) {
                    var created = new Date(Date.parse(v.created));
                    html += '<tr>';
                    html += '<td>'+(++offset)+'</td>';
                    html += '<td>'+v.name+'</td>';
                    html += '<td>'+v.email+'</td>';
                    html += '<td>'+created.toLocaleDateString('en-US')+' '+created.toLocaleTimeString('en-US')+'</td>';
                    html += '</tr>';
                });
                $("#total").html(data.total);
                $("#userList").html(html);
                if(data.total > 0){
                    $("#pagination-nav").show();
                    if(!isEmpty(data.links.first)){
                        $("#first-item").find('a').attr('href',data.links.first);
                    }else{
                        $("#first-item").hide()
                    }
                    if(!isEmpty(data.links.last)){
                        $("#last-item").find('a').attr('href',data.links.last);
                    }else{
                        $("#last-item").hide()
                    }
                    if(!isEmpty(data.links.current)){
                        $("#current-link").find('a').attr('href',data.links.current);
                    }else{
                        $("#current-link").hide()
                    }
                    if(!isEmpty(data.links.previous)){
                        $("#previous-link").find('a').attr('href',data.links.previous);
                    }else{
                        $("#previous-link").hide()
                    }
                    if(!isEmpty(data.links.next)){
                        $("#next-link").find('a').attr('href',data.links.next);
                    }else{
                        $("#next-link").hide()
                    }

                }
            }
            else {
                console.error(response);
            }
        });
    })
</script>

