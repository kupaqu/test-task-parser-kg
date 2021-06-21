# test-task-parser-kg
Необходимо написать скрипт, который бы парсил все записи с http://212.112.103.101/reestr (Государственный реестр лекарственных средств республики Киргизия). Сложность в том, что для отображения записей необходимо ввести, по крайней мере, 3 символа.

Требования:
  1. данные должны сохраняться в json-файл на сервере, с которого запускается скрипт;
  2. данные в итоговом файле не должны дублироваться;
  3. парсер должен предусматривать регулярный запуск, и иметь возможность отслеживания успешности его работы;
