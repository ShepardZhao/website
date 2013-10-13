<div id="initialPage">
    <table class="table table-bordered">
        <thead>
        <tr class="thead">
            <td><h4>System Info</h4></td>
            <td></td>

        </tr>
        </thead>
        <tbody>
        <tr>
            <td class="subHead">Web Url</td>
            <td class="subtr"><?php echo GlobalPath;?></td>
        </tr>
        <tr>
            <td class="subHead">Current Logined User</td>
            <td ><?php  echo $_SESSION['LoginedAdmministratorName'];?></td>
        </tr>
        <tr>
            <td class="subHead">System Status</td>
            <td><?php echo $BasicSettingClass->pushSettingData()['WebStatus'];?></td>
        </tr>
        <tr>
            <td class="subHead">Server Address</td>
            <td><?php $BasicSystemInfoClass->_SysInformationDisply('SERVER_ADDR');?></td>
        </tr>
        <tr>
            <td class="subHead">System Vsersion</td>
            <td><?php $BasicSystemInfoClass->_SysInformationDisply('SERVER_NAME');?></td>
        </tr>
        <tr>
            <td class="subHead">System Port</td>
            <td><?php $BasicSystemInfoClass->_SysInformationDisply('SERVER_PORT');?></td>
        </tr>
        <tr>
            <td class="subHead">System Time</td>
            <td><?php $BasicSystemInfoClass->_SysTime();?></td>
        </tr>
        <tr>
            <td class="subHead">Absolute Path</td>
            <td><?php $BasicSystemInfoClass->_SysInformationDisply('DOCUMENT_ROOT');?></td>
        </tr>
        <tr>
            <td class="subHead">Operate System</td>
            <td><?php $BasicSystemInfoClass->_SysInformationDisply('SERVER_SOFTWARE');?></td>
        </tr>

        <tr>
            <td class="subHead">Client IP</td>
            <td><?php $BasicSystemInfoClass->_SysInformationDisply('REMOTE_ADDR');?></td>
        </tr>

        <tr>
            <td class="subHead">Client Port</td>
            <td><?php $BasicSystemInfoClass->_SysInformationDisply('REMOTE_PORT');?></td>
        </tr>
        </tbody>
    </table>
</div>