<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html;charset=utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=EDGE">
        <meta name="renderer" content="webkit|ie-comp|ie-stand">
        <title>{{title}}</title>  
    </head>
    <body>		
        <div class="header">
            <div class="headerleft">
                <span class="title">
                    开发管理系统
                </span>
            </div>
            <div class="headerright">
                <span>您好，{{layout_user_name}}</span>
                <i></i>
                <span bmid="logout">退出</span>
            </div>
        </div>
        <div class="content">
            <div class="menu">
                {{layout_menu}}
            </div>
            <div class="viewport">
                {{layout_content}}            
            </div>
        </div>
        <div class="togglemenu">
            <i class="arrow svg_arrow_right"></i>
        </div>
    </body>
</html>
