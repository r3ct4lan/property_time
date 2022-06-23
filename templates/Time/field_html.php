<?php
/**
 * @var $arProperty
 * @var $value
 * @var $strHTMLControlName
 */

?>
<div class="adm-input-wrap">
    <input class="adm-input rpt-input-timeinterval" placeholder="04:20" type="text"
           name="<?= $strHTMLControlName["VALUE"] ?>" size="5"
           value="<?= htmlspecialcharsbx($value["VALUE"]) ?>">
    <script>
      document.addEventListener('DOMContentLoaded', function () {
        const regExp_sym = '^[0-9 :-]$',
          regExp_hour = '([0-1][0-9]|2[0-3])',
          regExp_min = '[0-5][0-9]',
          regExp_time = regExp_hour + ':' + regExp_min,
          regExp_steps = [
            '[0-2]',
            regExp_hour,
            regExp_hour + ':',
            regExp_hour + ':[0-5]',
            regExp_time,
          ],
          input = document.querySelector("input.rpt-input-timeinterval[name='<?= $strHTMLControlName["VALUE"] ?>']")
        if (input) {
          let last_value = input.value
          input.addEventListener('input', function (event) {
            if (event.inputType === 'insertText') {
              if (!new RegExp(regExp_sym).test(event.data))
                input.value = last_value

              if (input.value.length > 0 && input.value.length <= 5) {
                if (!new RegExp('^' + regExp_steps[input.value.length - 1] + '$').test(input.value))
                  input.value = last_value
                else if (input.value.length === 2) {
                  input.value += ':'
                }
              }

              if (input.value.length > 5)
                input.value = last_value
            }
            last_value = input.value
          })
          input.addEventListener('paste', e => e.preventDefault())
        }
      })
    </script>
</div>
