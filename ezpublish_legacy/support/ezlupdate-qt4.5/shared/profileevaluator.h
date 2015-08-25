/****************************************************************************
**
** Copyright (C) 2009 Nokia Corporation and/or its subsidiary(-ies).
** Contact: Qt Software Information (qt-info@nokia.com)
**
** This file is part of the Qt Linguist of the Qt Toolkit.
**
** $QT_BEGIN_LICENSE:LGPL$
** Commercial Usage
** Licensees holding valid Qt Commercial licenses may use this file in
** accordance with the Qt Commercial License Agreement provided with the
** Software or, alternatively, in accordance with the terms contained in
** a written agreement between you and Nokia.
**
** GNU Lesser General Public License Usage
** Alternatively, this file may be used under the terms of the GNU Lesser
** General Public License version 2.1 as published by the Free Software
** Foundation and appearing in the file LICENSE.LGPL included in the
** packaging of this file.  Please review the following information to
** ensure the GNU Lesser General Public License version 2.1 requirements
** will be met: http://www.gnu.org/licenses/old-licenses/lgpl-2.1.html.
**
** In addition, as a special exception, Nokia gives you certain
** additional rights. These rights are described in the Nokia Qt LGPL
** Exception version 1.0, included in the file LGPL_EXCEPTION.txt in this
** package.
**
** GNU General Public License Usage
** Alternatively, this file may be used under the terms of the GNU
** General Public License version 3.0 as published by the Free Software
** Foundation and appearing in the file LICENSE.GPL included in the
** packaging of this file.  Please review the following information to
** ensure the GNU General Public License version 3.0 requirements will be
** met: http://www.gnu.org/copyleft/gpl.html.
**
** If you are unsure which license is appropriate for your use, please
** contact the sales department at qt-sales@nokia.com.
** $QT_END_LICENSE$
**
****************************************************************************/

#ifndef PROFILEEVALUATOR_H
#define PROFILEEVALUATOR_H

#include "proitems.h"
#include "abstractproitemvisitor.h"

#include <QtCore/QIODevice>
#include <QtCore/QHash>
#include <QtCore/QStringList>
#include <QtCore/QStack>

QT_BEGIN_NAMESPACE

class ProFile;
class ProFileEvaluator;

void evaluateProFile(const ProFileEvaluator &visitor, QHash<QByteArray, QStringList> *varMap);
bool evaluateProFile(const QString &fileName, bool verbose, QHash<QByteArray, QStringList> *varMap);

class ProFileEvaluator
{
public:
    enum TemplateType {
        TT_Unknown = 0,
        TT_Application,
        TT_Library,
        TT_Subdirs
    };

    ProFileEvaluator();
    virtual ~ProFileEvaluator();

    ProFileEvaluator::TemplateType templateType();
    virtual bool contains(const QString &variableName) const;
    void setVerbose(bool on);

    bool queryProFile(ProFile *pro);
    bool accept(ProFile *pro);

    void addVariables(const QHash<QString, QStringList> &variables);
    void addProperties(const QHash<QString, QString> &properties);
    QStringList values(const QString &variableName) const;
    QStringList values(const QString &variableName, const ProFile *pro) const;
    QString propertyValue(const QString &val) const;

    // for our descendents
    virtual ProFile *parsedProFile(const QString &fileName);
    virtual void releaseParsedProFile(ProFile *proFile);
    virtual void logMessage(const QString &msg);
    virtual void errorMessage(const QString &msg); // .pro parse errors
    virtual void fileMessage(const QString &msg); // error() and message() from .pro file

private:
    class Private;
    Private *d;
};

QT_END_NAMESPACE

#endif // PROFILEEVALUATOR_H
