<div class="row padding10">
    <table>
        <tbody>
            <tr>
                <td width="150">{* take identifier from config *}
                    <img src="/captcha/{$element.attribute.id}/" width="150" height="50" alt="captcha image" title="captcha image" class="float-start">
                </td>
                <td>
                    {include file="phormix/phormix_input_default.tpl"}
                </td>
            </tr>
        </tbody>
    </table>
</div>