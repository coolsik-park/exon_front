<div class="webinar-cont2">
    <h3 class="sr-only">자료</h3>
    <div class="webinar-cont-ty2">
        <form name="uploadForm" id="uploadForm">
            <div class="wb10-btn">
                <button type="button" class="btn3" onclick="uploadFile()">저장하기</button>
            </div>
            <div class="mouse-area" id="dropZone">
                <label for="addFile"><span class="ico-plus-c">+</span></button>
                <input name="file[]" id="addFile" type="file" multiple="multiple" style="display:none">
                <p>마우스로 자료를 끌어오세요</p>
            </div>
            <br><br>
            <div id = "fileTableTbody" class="data-itmes">
                <!-- <p>저장할 파일</p> -->
            </div>
            <div>
                <!-- <br><br>
                <p>저장된 파일</p>
                <br> -->   
            </div>
        </form>                   
    </div>                               
</div>

<script>
// 파일 리스트 번호
var fileIndex = 0;
// 등록할 전체 파일 사이즈
var totalFileSize = 0;
// 파일 리스트
var fileList = new Array();
// 파일 사이즈 리스트
var fileSizeList = new Array();
// 등록 가능한 파일 사이즈 MB
var uploadSize = 5000000;
// 등록 가능한 총 파일 사이즈 MB
var maxUploadSize = 5000000;

$(function (){
    // 파일 드롭 다운
    fileDropDown();
});

// 파일 드롭 다운
function fileDropDown(){
    var dropZone = $("#dropZone");
    //Drag기능 
    dropZone.on('dragenter',function(e){
        e.stopPropagation();
        e.preventDefault();
        // 드롭다운 영역 css
        dropZone.css('background-color','#E3F2FC');
    });
    dropZone.on('dragleave',function(e){
        e.stopPropagation();
        e.preventDefault();
        // 드롭다운 영역 css
        dropZone.css('background-color','#FFFFFF');
    });
    dropZone.on('dragover',function(e){
        e.stopPropagation();
        e.preventDefault();
        // 드롭다운 영역 css
        dropZone.css('background-color','#E3F2FC');
    });
    dropZone.on('drop',function(e){
        e.preventDefault();
        // 드롭다운 영역 css
        dropZone.css('background-color','#FFFFFF');
        
        var files = e.originalEvent.dataTransfer.files;
        if(files != null){
            if(files.length < 1){
                alert("폴더 업로드 불가");
                return;
            }
            selectFile(files)
        }else{
            alert("ERROR");
        }
    });
}

//파일 불러오기
$("input[type=file]").change(function (e) {
    e.preventDefault();
    var files = document.getElementById("addFile").files;
    if(files != null){
        if(files.length < 1){
            alert("폴더 업로드 불가");
            return;
        }
        selectFile(files)
    }else{
        alert("ERROR");
    }
});

// 파일 선택시
function selectFile(files){
    // 다중파일 등록
    if(files != null){
        for(var i = 0; i < files.length; i++){
            // 파일 이름
            var fileName = files[i].name;
            var fileNameArr = fileName.split("\.");
            // 확장자
            var ext = fileNameArr[fileNameArr.length - 1];
            // 파일 사이즈(단위 :MB)
            var fileSize = files[i].size / 1024;
            
            if($.inArray(ext, ['mp4']) < 0){
                // 확장자 체크
                alert("mp4 확장자 외 파일은 업로드가 불가능합니다.");
                break;
            }else if(fileSize > uploadSize){
                // 파일 사이즈 체크
                alert("용량 초과\n업로드 가능 용량 : " + uploadSize / 1000 + " MB");
                break;
            }else{
                // 전체 파일 사이즈
                totalFileSize += fileSize;
                
                // 파일 배열에 넣기
                fileList[fileIndex] = files[i];
                
                // 파일 사이즈 배열에 넣기
                fileSizeList[fileIndex] = fileSize;

                // 업로드 파일 목록 생성
                addFileList(fileIndex, fileName, fileSize);

                // 파일 번호 증가
                fileIndex++;
            }
        }
    }else{
        alert("ERROR");
    }
}

// 업로드 파일 목록 생성
function addFileList(fIndex, fileName, fileSize){
    var html = "";
    html += "<a id='fileTr_" + fIndex + "' class='data-itme edit'>";
    html += "<span class='tx'>" + fileName + "</span>";
    html += "<span class='kb'>" + fileSize.toFixed(1) + "KB</span>";
    html += "<button type='button' onclick='deleteFile(" + fIndex + "); return false;' class='btn-del'>삭제</button>";
    html += "</a>";

    $('#fileTableTbody').append(html);
}

// 업로드 파일 삭제
function deleteFile(fIndex){
    // 전체 파일 사이즈 수정
    totalFileSize -= fileSizeList[fIndex];
    
    // 파일 배열에서 삭제
    delete fileList[fIndex];
    
    // 파일 사이즈 배열 삭제
    delete fileSizeList[fIndex];
    
    // 업로드 파일 테이블 목록에서 삭제
    $("#fileTr_" + fIndex).remove();
}

function deleteUploadedFile(id){
    jQuery.ajax({
        url: "/exhibition-stream/delete-exhibition-file/" + id, 
        method: 'DELETE',
        type: 'json',
    }).done(function(data) {
        if (data.status == 'success') {
            $("#" + id).remove();
        } else {
            alert("오류가 발생하였습니다. 잠시 후 다시 시도해주세요.")
        }
    });
}

//파일 등록
function uploadFile(){
    // 등록할 파일 리스트
    var uploadFileList = Object.keys(fileList);
        
    if(confirm("등록 하시겠습니까?")){
        // 등록할 파일 리스트를 formData로 데이터 입력
        var formData = new FormData();
        for(var i = 0; i < uploadFileList.length; i++){
            formData.append('file[]', fileList[uploadFileList[i]]);
        }
        
        jQuery.ajax({
            url: 'https://orcaexon.co.kr/vod',
            processData: false,
            contentType: false,
            cache: false,
            data: formData,
            method: 'POST',
            success: function () {
                alert("저장되었습니다.");
            },
            error: function () {
                alert("오류가 발생하였습니다. 잠시 후 다시 시도해주세요.");
            }  
        });
    }
}
</script>