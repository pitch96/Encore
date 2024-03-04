//
//  _StarGlobalEntertainment_TKCSUITestsLaunchTests.swift
//  5StarGlobalEntertainment-TKCSUITests
//
//  Created by chetu on 18/11/22.
//

import XCTest

final class _StarGlobalEntertainment_TKCSUITestsLaunchTests: XCTestCase {

    override class var runsForEachTargetApplicationUIConfiguration: Bool {
        true
    }

    override func setUpWithError() throws {
        continueAfterFailure = false
    }

    func testLaunch() throws {
        let app = XCUIApplication()
        app.launch()

        // Insert steps here to perform after app launch but before taking a screenshot,
        // such as logging into a test account or navigating somewhere in the app

        let attachment = XCTAttachment(screenshot: app.screenshot())
        attachment.name = "Launch Screen"
        attachment.lifetime = .keepAlways
        add(attachment)
    }
}
