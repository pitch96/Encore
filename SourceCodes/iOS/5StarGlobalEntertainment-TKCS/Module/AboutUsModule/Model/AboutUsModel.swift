//
//  AboutUsModel.swift
//  5StarGlobalEntertainment-TKCS
//
//  Created by chetu on 24/01/23.
//

import Foundation

// MARK: - About us Model
struct AboutUsModel: Codable {
    var statusCode: Int?
    var success: Bool?
    var message, data: String?
}
